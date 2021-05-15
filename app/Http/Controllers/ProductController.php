<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Characteristic;
use App\Color;
use App\Currency;
use App\Element;
use App\Http\HelperClasses\Combinations;
use App\Variation;
use App\VariationTranslation;
use Illuminate\Http\Request;
use App\Product;
use App\ProductTranslation;
use App\ProductStock;
use App\Category;
use App\Language;
use Auth;
use Session;
use ImageOptimizer;
use DB;
use Illuminate\Support\Str;
use Artisan;
use App\Product_Warehouse;
use App\Warehouse;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    public function changeOnModerationAccept(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'on_moderation' => 0,
            'is_accepted' => 1
        ]);

        return redirect()->route('products.manage');
    }

    public function changeOnModerationRefuse(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'on_moderation' => 0,
            'is_accepted' => 0
        ]);

        return redirect()->route('products.manage');
    }

    public function manageProducts(Request $request)
    {
        $products = Product::where('is_accepted', 1)->latest()->paginate(10);
        $type = 'Seller';

        return view('backend.product.manage', [
            'products' => $products,
            'type' => $type
        ]);
    }

    public function characteristics(Request $request, $id)
    {
        if ($request->method() == 'POST') {
            $product = Product::where('id', $id)->firstOrFail();
            $product->characteristicValues()->delete();
            if ($request->get('attr')) {
                foreach ($request->get('attr') as $item) {
                    $data = [
                        'product_id' => $product->id,
                        'parent_id' => $item['parent_id'],
                        'attr_id' => $item['id'],
                        'name' => $item['name'],
                    ];


                    if (isset($item['values'])) {
                       $data['values'] = implode(' / ', $item['values']);
                    }
                    // dd($data);
                    CharacteristicValues::create($data);
                }
            }

            flash(translate('Saved successfully'))->success();
            return back();
        } else {
            $product = Product::where('id', $id)->with(['characteristicValues'])->firstOrFail();
            $options = $product->category->productAttributes;
            // dd($product->characteristicValues);
            return view('backend.product.products.add_attr', compact(
                'product', 'options'
            ));
        }
    }

    public function addInStockProductAttrs(Request $request, $id)
    {
        $product = ProductStock::where('id', $id)->firstOrFail();
        $lang = $request->get('lang');
        $options = ProductAttribute::all();

        return view('backend.product.products.add_attr', [
            'product' => $product,
            'lang' => $lang,
            'options' => $options
        ]);
    }

    public function inStock($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $type = 'All';

        return view('backend.product.products.in_stock', [
            'product' => $product,
            'products' => $product->stocks()->paginate(15),
            'type' => $type
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();
        $col_name = null;
        $query = null;
        $sort_search = null;

        $variations = Variation::whereNotNull('element_id');
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
        $type = 'In House';
        return view('backend.product.products.index', compact('variations', 'type', 'col_name', 'query', 'sort_search'));
    }

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

        $variations = Variation::whereNotNull('element_id');
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
        return view('backend.product.products.index', compact('variations', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    public function all_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;

        $variations = Variation::where('element_id', '<>', null);
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
        $type = 'All';

        return view('backend.product.products.index', compact('variations', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $elements = Element::all();
        return view('backend.product.products.create', compact('elements'));
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

        $name = $element->name;

        $added_by = Auth::user()->user_type;
        $minimum_price=0;
        $product_price=0;
        $product_id=0;
        $total_stock=0;
        $variation= new Variation;
        $variation->name=$name;
        $variation->save();
        $product_ids=array();
        if ($request->has('variation')) {
            foreach ($request->variation as $variant) {

                $product = new Product;
                $product->name=$variant["name"];
                $product->added_by=$added_by;
                $product->user_id=$user_id;
                $product->slug=SlugService::createSlug(Product::class, 'slug', slugify($variant["slug"]));
                $product->currency_id= (int)$variant["currency"];
                $product->price=(double)$variant["price"];
                $product->discount=(double)$variant["discount"];
                $product->discount_type=$variant["discount_type"];
                if(array_key_exists('todays_deal', $variant)){
                    ($variant["todays_deal"]=="on" )?$product->todays_deal=true:$product->todays_deal=false;
                }else{
                    $product->todays_deal=false;
                }
                if(array_key_exists('published', $variant)){
                    ($variant["published"]=="on" )?$product->published=true:$product->published=false;
                }else{
                    $product->published=false;
                }
                $product->delivery_group_id=$variant["delivery_type"];
                $product->qty=(int)$variant["quantity"];
                $product->tax=(double)$variant["tax"];
                $product->tax_type=$variant["tax_type"];
                $product->rating=0;
                $product->barcode=rand(10000, 999999);
                $product->earn_point=0;
                $product->num_of_sale=0;
                $product->variation_id=$variation->id;
                $product->save();

                $product_price=$product->price;
                $total_stock=$total_stock+$product->qty;
                if($currency=Currency::findOrFail($product->currency_id)){
                    $product_price=$product_price/$currency->exchange_rate;
                }
                if($minimum_price>$product_price || $minimum_price==0){
                    $minimum_price=$product_price;
                    $product_id=$product->id;
                    $product_ids=array();
                    $product_ids[]=$product->id;
                }else if($minimum_price==$product_price && $product_price!=0){
                    $product_ids[]=$product->id;
                }
                foreach (Language::all() as $language){
                    // Product Translations
                    $product_translation = ProductTranslation::firstOrNew(['lang' => $language->code, 'product_id' => $product->id]);
                    $product_translation->name = $product->name;
                    $product_translation->save();
                }
            }
        }
        if($product_id!=0 && $product=Product::findOrFail($product_id)){
            if($element=Element::findOrFail($request->element_id)){
                $variation->name=$element->name." ".$product->name." ".$product->user_id;
                $variation->lowest_price_id=$product->id;
                $variation->slug=$slug;
                $variation->element_id=$element->id;
                $variation->prices=json_encode($product_ids);
                $variation->variant=$product->slug;
                $variation->sku=$product->slug;
                $variation->num_of_sale=0;
                $variation->qty=$total_stock;
                $variation->rating=0;
                $variation->user_id=$user_id;
                $variation->save();

                foreach (Language::all() as $language){
                    $variation_translation = VariationTranslation::firstOrNew(['lang' => $language->code, 'variation_id' => $variation->id]);
                    $variation_translation->name = $name;
                    $variation_translation->save();
                }

            }
        }



        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return redirect()->route('products.admin');
        } else {
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= 1;
                $seller->save();
            }
            return redirect()->route('seller.products');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function admin_product_edit($id)
    {
        $variation = Variation::findOrFail($id);
        $lang = default_language();
        $currencies=Currency::where('status', true)->get();
        $products = $variation->products;
        return view('backend.product.products.edit', compact('variation', 'products', 'currencies', 'lang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit($id)
    {
        $this->admin_product_edit($id);
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
            $user_id = \App\User::where('user_type', 'admin')->first()->id;
        }
        $name = $request->name;
        $slug = SlugService::createSlug(Variation::class, 'slug', slugify($name));
        $added_by = Auth::user()->user_type;
        $minimum_price=0;
        $product_price=0;
        $product_id=0;
        $total_stock=0;
        $variation=Variation::findOrFail($id);
        $variation->name=$name;
        $variation->save();
        $product_ids=array();
        if ($request->has('variation')) {
            foreach ($request->variation as $key=>$variant) {
                $product = Product::findOrFail($key);
                $product->name=$variant["name"];
                $product->added_by=$added_by;
                $product->user_id=$user_id;
                if($product->slug!=SlugService::createSlug(Product::class, 'slug', slugify($variant["slug"])))
                    $product->slug=SlugService::createSlug(Product::class, 'slug', slugify($variant["slug"]));
                $product->currency_id= (int)$variant["currency"];
                $product->price=(double)$variant["price"];
                $product->discount=(double)$variant["discount"];
                $product->discount_type=$variant["discount_type"];
                if(array_key_exists('todays_deal', $variant)){
                    ($variant["todays_deal"]=="on" )?$product->todays_deal=true:$product->todays_deal=false;
                }else{
                    $product->todays_deal=false;
                }
                if(array_key_exists('published', $variant)){
                    ($variant["published"]=="on" )?$product->published=true:$product->published=false;
                }else{
                    $product->published=false;
                }
                $product->delivery_group_id=$variant["delivery_type"];
                $product->qty=(int)$variant["quantity"];
                $product->tax=(double)$variant["tax"];
                $product->tax_type=$variant["tax_type"];
//                $product->rating=0;
                $product->barcode=rand(10000, 999999);
                $product->earn_point=0;
                $product->num_of_sale=0;
                $product->variation_id=$variation->id;
                $product->save();

                $product_price=$product->price;
                $total_stock=$total_stock+$product->qty;
                if($currency=Currency::findOrFail($product->currency_id)){
                    $product_price=$product_price/$currency->exchange_rate;
                }
                if($minimum_price>$product_price || $minimum_price==0){
                    $minimum_price=$product_price;
                    $product_id=$product->id;
                    $product_ids=array();
                    $product_ids[]=$product->id;
                }else if($minimum_price==$product_price && $product_price!=0){
                    $product_ids[]=$product->id;
                }
                foreach (Language::all() as $language){
                    // Product Translations
                    $product_translation = ProductTranslation::firstOrNew(['lang' => $language->code, 'product_id' => $product->id]);
                    $product_translation->name = $product->name;
                    $product_translation->save();
                }
            }
        }
        if($product_id!=0 && $product=Product::findOrFail($product_id) ){
//            if($element=Element::findOrFail($request->element_id)){
                $variation->lowest_price_id=$product->id;
                $variation->slug=$slug;
//                $variation->element_id=$element->id;
                $variation->prices=json_encode($product_ids);
                $variation->variant=$product->slug;
                $variation->sku=$product->slug;
//                $variation->num_of_sale=0;
                $variation->qty=$total_stock;
                $variation->rating=0;
                $variation->user_id=$user_id;
                $variation->save();
                foreach (Language::all() as $language){
                    $variation_translation = VariationTranslation::firstOrNew(['lang' => $language->code, 'variation_id' => $variation->id]);
                    $variation_translation->name = $name;
                    $variation_translation->save();
                }


//            }
        }

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
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
            $variation = Variation::findOrFail($id);
            $products = $variation->products;
            foreach ($products as $product){
                foreach ($product->product_translations as $product_translation) {
                    $product_translation->delete();
                }
                $product->delete();
            }
             $variation->delete();
            flash(translate('Variation has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller.products');
            }
        }catch (\Exception $e){
             flash(translate('Something went wrong'))->error();
             return back();
        }
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {
        $product = Product::find($id);
        $product_new = $product->replicate();
        // $product_new->slug = substr($product_new->slug, 0, -5) . Str::random(5);
        if ($product_new->save()) {
            flash(translate('Product has been duplicated successfully'))->success();
            if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
                if ($request->type == 'In House')
                    return redirect()->route('products.admin');
                elseif ($request->type == 'Seller')
                    return redirect()->route('products.seller');
                elseif ($request->type == 'All')
                    return redirect()->route('products.all');
            } else {
                return redirect()->route('seller.products');
            }
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
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

        $product->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
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
            foreach ($products as $product){
                $product->todays_deal = $request->status;
                $product->save();
            }
            return 1;
        }catch (\Exception $e){
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
            foreach ($products as $product){
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
        }catch (\Exception $e){
            return 0;
        }
    }

    public function updateFeatureds(Request $request)
    {
        try {
            $variation = Variation::findOrFail($request->id);
            $products = $variation->products;
//            $product = Product::findOrFail($request->id);
//            $variation = Variation::findOrFail('id', $product->variation_id);
//            $products = Product::where('variation_id', $variation->id)->get();
            foreach ($products as $product){
                $product->featured = $request->status;
                $product->save();
            }
            return 1;
        }catch (\Exception $e){
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
            foreach ($products as $product){
                $product->seller_featured = $request->status;
                $product->save();
            }
            return 1;
        }catch (\Exception $e){
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

//    public function sku_combination(Request $request)
//    {
//        $options = array();
//        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
//            $colors_active = 1;
//            array_push($options, $request->colors);
//        } else {
//            $colors_active = 0;
//        }
//
//        $unit_price = $request->unit_price;
//        $product_name = $request->name;
//
//        if ($request->has('choice_no')) {
//            foreach ($request->choice_no as $key => $no) {
//                $name = 'choice_options_' . $no;
//                $data = array();
//                foreach (json_decode($request[$name][0]) as $key => $item) {
//                    array_push($data, $item->value);
//                }
//                array_push($options, $data);
//            }
//        }
//
//        $combinations = Combinations::makeCombinations($options);
//        return view('backend.product.products.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
//    }

    public function make_combination(Request $request){
        try{
            $element = Element::findOrFail($request->element_id);
            $combinations = $element->variations;
//            $choice_option_list = json_decode($element->choice_options, true);
//            $color_list = json_decode($element->colors, true);
//            $variations=array();
//            if($choice_option_list!=null && is_array($choice_option_list)){
//                foreach ($choice_option_list as $index=>$attributes){
//                    foreach ($attributes as $attribute_id=>$values) {
//                        if($attribute = Attribute::find($attribute_id)){
//                            if($attribute->combination==true){
//                                $characteristics = Characteristic::whereIn('id', $values)->pluck('name')->toArray();
//                                $variations[] = $characteristics;
//                            }
//                        }
//                    }
//                }
//            }
//            if($color_list!=null && is_array($color_list)){
//                $colors=Color::whereIn('code', $color_list)->pluck('name')->toArray();
//                $variations[]=$colors;
//            }
//            $combinations = Combinations::makeCombinations($variations);
            $lang=default_language();
            $currencies=Currency::where('status', true)->get();

            return view('backend.product.products.design_make_combination', compact('combinations', 'element', 'lang', 'currencies'));

        }catch (\Exception $e){

        }
        return null;
    }
//    public function make_combination($id){
//        $element = Element::findOrFail($id);
//        $characteristic_list = json_decode($element->characteristics);
//        $color_list = json_decode($element->colors);
//
//        if($characteristic_list!=null && is_array($characteristic_list)){
//            $characteristics=Characteristic::whereIn('id', $characteristic_list)->pluck('slug')->toArray();
//        }
//        if($color_list!=null && is_array($color_list)){
//            $colors=Color::whereIn('code', $color_list)->pluck('name')->toArray();
//        }
//        //$options = array_merge($characteristics, $colors);
////        cartesian($colors);
////        $combinations = Combinations::cartesian($characteristics);
//        $combinations = Combinations::makeCombinations($characteristics);
//        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'element'));
//    }
    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach (json_decode($request[$name][0]) as $key => $item) {
                    array_push($data, $item->value);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }

    public function productWarehouseData($id)
    {
        $warehouse = [];
        $qty = [];
        $warehouse_name = [];
        $variant_name = [];
        $variant_qty = [];
        $product_warehouse = [];
        $product_variant_warehouse = [];
        $lims_product_data = Product::select('id', 'is_variant')->find($id);
        // if($lims_product_data->is_variant) {
        //     $lims_product_variant_warehouse_data = Product_Warehouse::where('product_id', $lims_product_data->id)->orderBy('warehouse_id')->get();
        //     $lims_product_warehouse_data = Product_Warehouse::select('warehouse_id', DB::raw('sum(qty) as qty'))->where('product_id', $id)->groupBy('warehouse_id')->get();
        //     foreach ($lims_product_variant_warehouse_data as $key => $product_variant_warehouse_data) {
        //         $lims_warehouse_data = Warehouse::find($product_variant_warehouse_data->warehouse_id);
        //         $lims_variant_data = Variant::find($product_variant_warehouse_data->variant_id);
        //         $warehouse_name[] = $lims_warehouse_data->name;
        //         $variant_name[] = $lims_variant_data->name;
        //         $variant_qty[] = $product_variant_warehouse_data->qty;
        //     }
        // }
        // else{
        $lims_product_warehouse_data = Product_Warehouse::where('product_id', $id)->get();
        // }
        foreach ($lims_product_warehouse_data as $key => $product_warehouse_data) {
            $lims_warehouse_data = Warehouse::find($product_warehouse_data->warehouse_id);
            $warehouse[] = $lims_warehouse_data->name;
            $qty[] = $product_warehouse_data->qty;
        }

        $product_warehouse = [$warehouse, $qty];
        $product_variant_warehouse = [$warehouse_name, $variant_name, $variant_qty];
        return ['product_warehouse' => $product_warehouse, 'product_variant_warehouse' => $product_variant_warehouse];
    }


}
