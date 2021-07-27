<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Element;
use App\Http\HelperClasses\Combinations;
use App\Variation;
use Illuminate\Http\Request;
use App\Product;
use App\ProductTranslation;
use App\Language;
use Auth;
use Session;
use ImageOptimizer;
use DB;
use Illuminate\Support\Str;
use Artisan;
use App\Product_Warehouse;
use App\User;
use App\Warehouse;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;

class SellerProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;

        $variations = Variation::whereNotNull('element_id')->whereNotNull('lowest_price_id');
        if ($request->has('user_id') && $request->user_id != null) {
            $variations = $variations->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $variations = $variations
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $variations = $variations->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        $variations = $variations->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';
        return view('frontend.user.seller.products.index', compact('variations', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->user_type == 'seller') {
            $user_id = Auth::user()->id;
        } else {
            $user_id = \App\User::where('user_type', 'admin')->first()->id;
        }
        $element = Element::findOrFail($request->element_id);
        if ($request->has('variation')) {
            foreach ($request->variation as $variant) {
                if ($variation = Variation::findOrFail($variant["id"])) {
                    $product = new Product;
                    $product->is_accepted=false;
                    $product->element_id=$element->id;
                    if(Auth::user()->user_type == 'seller' && $shop_name=Auth::user()->shop->name){
                        $product_name = $variation->name . " от " . $shop_name??Auth::user()->shop->name;
                    }else{
                        $product_name = $variation->name. " от " . Auth::user()->name;
                    }
                    // $product_name = $variation->name;
                    // . " ".$variant["price"];
                    $product->name = $product_name;
                    $product->added_by = Auth::user()->user_type;
                    $product->user_id = $user_id;
                    $product->slug = SlugService::createSlug(Product::class, 'slug', slugify($product_name));
                    $product->currency_id = (int)$variant["currency"];
                    $product->price = (float)$variant["price"];
                    $product->discount = (float)$variant["discount"];
                    $product->discount_type = $variant["discount_type"];
                    if (array_key_exists('todays_deal', $variant)) {
                        ($variant["todays_deal"] == "on") ? $product->todays_deal = true : $product->todays_deal = false;
                    } else {
                        $product->todays_deal = false;
                    }
                    if (array_key_exists('published', $variant)) {
                        ($variant["published"] == "on") ? $product->published = true : $product->published = false;
                    } else {
                        $product->published = false;
                    }
                    if (array_key_exists('featured', $variant)) {
                        ($variant["featured"] == "on") ? $product->seller_featured = true : $product->seller_featured = false;
                    } else {
                        $product->seller_featured = false;
                    }
                    $product->delivery_type = $variant["delivery_type"];
                    $product->sku = $variant["sku"];
                    $product->qty = (int)$variant["quantity"];
                    $product->tax = (float)$variant["tax"];
                    $product->tax_type = $variant["tax_type"];
                    $product->rating = 0;
                    // $product->barcode = $variant["barcode"];
                    $product->earn_point = 0;
                    $product->num_of_sale = 0;
                    $product->variation_id = $variation->id;
                    $product->save();
                    // if ($product->save()) {
                    //     $products = Product::where('variation_id', $variation->id);
                    //     if(count($products->get())>0){
                    //         $min_price=$products->min("price");
                    //         $lowest_price_list=$products->where('price', $min_price)->pluck('id');
                    //         $lowest_price_id=$lowest_price_list[rand(0, count($lowest_price_list)-1)];
                    //         $variation->lowest_price_id=$lowest_price_id;
                    //         $variation->qty=$products->sum('qty');
                    //         $variation->num_of_sale=$products->sum('num_of_sale');
                    //         $variation->prices=$products->pluck('price');
                    //         $variation->rating=(double)$products->sum('rating')/$products->count();
                    //         $variation->save();
                    //     }

                    // }
                }
                //Language chaqnges
                foreach (Language::all() as $language) {
                    // Product Translations
                    $product_translation = ProductTranslation::firstOrNew(['lang' => $language->code, 'product_id' => $product->id]);
                    $product_translation->name = $product->name;
                    $product_translation->save();
                }
            }
        }

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        if (Auth::user()->user_type == 'seller' || Auth::user()->user_type == 'staff') {
            // return redirect()->route('seller.products.admin');
            return redirect()->route('seller.elements.all');
        } else {
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= 1;
                $seller->save();
            }
            // return redirect()->route('seller.products');
            return redirect()->route('seller.elements.all');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit($id)
    {
        $variation = Variation::findOrFail($id);
        $lang = default_language();
        $currencies = Currency::where('status', true)->get();
        $products = $variation->products;
        return view('frontend.user.seller.products.edit', compact('variation', 'products', 'currencies', 'lang'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->user_type == 'seller') {
            $user_id = Auth::user()->id;
        } else {
            $user_id = User::where('user_type', 'admin')->first()->id;
        }
        $user=User::findOrFail($user_id);
        $element = Element::findOrFail($request->id);
        if ($request->has('variation')) {
            foreach ($request->variation as $variant) {
                // dd($variant["id"]);
                if ($product=Product::where('id',(int)$variant["id"])->first()){
                    $variation = Variation::where('id',(int)$variant["variation_id"])->first();
                    if($user->user_type == 'seller' && $shop_name=$user->shop->name){
                        $product_name = $variation->name . " от " . $shop_name??$user->name;
                    }else{
                        $product_name = $variation->name. " от " . $user->name;
                    }
                    $product->name = $product_name;
                    $product->added_by = $user->user_type;
                    $product->user_id = $user_id;
                    if ($product->slug != SlugService::createSlug(Product::class, 'slug', slugify($product_name)))
                        $product->slug = SlugService::createSlug(Product::class, 'slug', slugify($product_name));
                    $product->currency_id = (int)$variant["currency"];
                    $product->price = (float)$variant["price"];
                    $product->discount = (float)$variant["discount"];
                    $product->discount_type = $variant["discount_type"];
                    if (array_key_exists('todays_deal', $variant)) {
                        ($variant["todays_deal"] == "on") ? $product->todays_deal = true : $product->todays_deal = false;
                    } else {
                        $product->todays_deal = false;
                    }
                    if (array_key_exists('published', $variant)) {
                        ($variant["published"] == "on") ? $product->published = true : $product->published = false;
                    } else {
                        $product->published = false;
                    }
                    if (array_key_exists('featured', $variant)) {
                        ($variant["featured"] == "on") ? $product->seller_featured = true : $product->seller_featured = false;
                    } else {
                        $product->seller_featured = false;
                    }
                    $product->delivery_type = $variant["delivery_type"];
                    $product->sku = $variant["sku"];
                    $product->qty = (int)$variant["quantity"];
                    $product->tax = (float)$variant["tax"];
                    $product->tax_type = $variant["tax_type"];
                    $product->variation_id = $variation->id;
                    $product->element_id=$element->id;
                    $product->save();
                }else if((int)$variant["quantity"]>0){
                    $product = new Product;
                    $product->element_id=$element->id;
                    $variation = Variation::where('id',(int)$variant["variation_id"])->first();
                    if($user->user_type == 'seller' && $shop_name=$user->shop->name){
                        $product_name = $variation->name . " от " . $shop_name??$user->name;
                    }else{
                        $product_name = $variation->name. " от " . $user->name;
                    }
                    $product->name = $product_name;
                    $product->added_by = $user->user_type;
                    $product->user_id = $user_id;
                    $product->slug = SlugService::createSlug(Product::class, 'slug',  slugify($product_name));
                    $product->currency_id = (int)$variant["currency"];
                    $product->price = (float)$variant["price"];
                    $product->discount = (float)$variant["discount"];
                    $product->discount_type = $variant["discount_type"];
                    if (array_key_exists('todays_deal', $variant)) {
                        ($variant["todays_deal"] == "on") ? $product->todays_deal = true : $product->todays_deal = false;
                    } else {
                        $product->todays_deal = false;
                    }
                    if (array_key_exists('published', $variant)) {
                        ($variant["published"] == "on") ? $product->published = true : $product->published = false;
                    } else {
                        $product->published = false;
                    }
                    if (array_key_exists('featured', $variant)) {
                        ($variant["featured"] == "on") ? $product->featured = true : $product->featured = false;
                    } else {
                        $product->featured = false;
                    }
                    $product->is_accepted=false;
                    $product->delivery_type = $variant["delivery_type"];
                    $product->sku = $variant["sku"];
                    $product->qty = (int)$variant["quantity"];
                    $product->tax = (float)$variant["tax"];
                    $product->tax_type = $variant["tax_type"];
                    $product->rating = 0;
                    $product->earn_point = 0;
                    $product->num_of_sale = 0;
                    $product->variation_id = $variation->id;
                    $product->save();
                }
            }
        }

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('seller.elements.all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            // $products = $variation->products;
            // foreach ($products as $product) {
            //     $product->delete();
            // }
            // dd($product);
            $product->forceDelete();
            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return redirect()->back();
        } catch (\Exception $e) {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        $product->on_moderation = 1;

        if ($product->added_by == 'seller' && \App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            $seller = $product->user->seller;
            if ($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0) {
                return 0;
            }
        }

        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->seller_featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updateTodaysDeals(Request $request)
    {
        try {
            $variation = Variation::findOrFail($request->id);
            $products = $variation->products;
            //            $product = Product::findOrFail($request->id);
            //            $variation = Variation::findOrFail('id', $product->variation_id);
            //            $products = Product::where('variation_id', $variation->id)->get();
            foreach ($products as $product) {
                $product->todays_deal = $request->status;
                $product->save();
            }
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function updatePublisheds(Request $request)
    {
        try {
            $variation = Variation::findOrFail($request->id);
            $products = $variation->products;
            //            $product = Product::findOrFail($request->id);
            //            $variation = Variation::findOrFail('id', $product->variation_id);
            //            $products = Product::where('variation_id', $variation->id)->get();
            foreach ($products as $product) {
                $product->published = $request->status;
                $product->on_moderation = 1;
                if ($product->added_by == 'seller' && \App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                    $seller = $product->user->seller;
                    if ($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0) {
                        continue;
                    }
                }
                $product->save();
            }
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function updateSellerFeatureds(Request $request)
    {
        try {
            $variation = Variation::findOrFail($request->id);
            $products = $variation->products;
            //            $product = Product::findOrFail($request->id);
            //            $variation = Variation::findOrFail('id', $product->variation_id);
            //            $products = Product::where('variation_id', $variation->id)->get();
            foreach ($products as $product) {
                $product->seller_featured = $request->status;
                $product->save();
            }
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function updateSellerFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->seller_featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }
    public function make_combination(Request $request)
    {
        try {
            $element = Element::findOrFail($request->element_id);
            $combinations = $element->combinations;
            $lang = default_language();
            $currencies = Currency::where('status', true)->get();
            return view('frontend.user.seller.products.make_combination', compact('combinations', 'element', 'lang', 'currencies'));
        } catch (\Exception $e) {
        }
        return null;
    }
}
