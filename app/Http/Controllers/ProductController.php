<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Characteristic;
use App\Color;
use App\Element;
use App\Http\HelperClasses\Combinations;
use App\Models\CharacteristicValues;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Product;
use App\ProductTranslation;
use App\ProductStock;
use App\Category;
use App\Language;
use Auth;
use App\SubSubCategory;
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

        $type = 'In House';
        $col_name = null;
        $query = null;
        $sort_search = null;

        $products = Product::where('added_by', 'admin');

        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null) {
            $products = $products
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $products = $products->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'sort_search'));
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
        $products = Product::where('added_by', 'seller');
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $products = $products
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    public function all_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $products = $products
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->paginate(15);
        $type = 'All';

        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
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
        $name = $request->name;
        $slug = SlugService::createSlug(Product::class, 'slug', slugify($name));
        $added_by = Auth::user()->user_type;
        $all_products = array();
        if ($request->has('variation')) {
            foreach ($request->variation as $variation) {
//                if($variation["quantity"] > 0 ){
                    $product = new Product;
                    $product->name=$name;
                    $product->added_by=$added_by;
                    $product->user_id=$user_id;
                    $product->slug=SlugService::createSlug(Product::class, 'slug', slugify($variation["slug"]));
                    $product->currency_id=$variation["currency"];
                    $product->price=$variation["price"];
                    $product->discount=$variation["discount"];
                    $product->discount_type=$variation["discount_type"];
//                $product->variation_id=$variation["variation_id"]
                    $product->todays_deal=$variation["todays_deal"];
                    $product->num_of_sale=0;
                    $product->delivery_group_id=$variation["delivery_type"];
                    $product->qty=$variation["quantity"];
                    $product->published=$variation["published"];
                    $product->tax=$variation["tax"];
                    $product->tax_type=$variation["tax_type"];
                    //$product->save();
                    $all_products[]=$product;
//                }
            }
            dd($all_products);
        }
        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $name;
        $product_translation->save();

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
    public function admin_product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        ($product->category)? $productAttributes = $product->category->productAttributes : $productAttributes = [];
        $selectedProductAttributes = $product->productAttributes->pluck('id')->toArray();
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::all()->toTree();

        return view('backend.product.products.edit', compact('product', 'categories', 'tags', 'lang', 'productAttributes', 'selectedProductAttributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::all()->toTree();
        return view('backend.product.products.edit', compact('product', 'categories', 'tags', 'lang'));
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
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
        $product = Product::findOrFail($id);
        $product->productAttributes()->detach();
        $product->productAttributes()->attach($request->get('attrs'));
        $product->subsubcategory_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->current_stock = $request->current_stock;
        $product->barcode = $request->barcode;


        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            } else {
                $product->refundable = 0;
            }
        }

        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $product->name = $request->name;
            $product->unit = $request->unit;
            $product->description = $request->description;
            if($product->slug!=$request->slug)
                $product->slug = SlugService::createSlug(Product::class, 'slug', slugify($request->name));
        }

        $product->photos = $request->photos;
        $product->thumbnail_img = $request->thumbnail_img;
        $product->min_qty = $request->min_qty;

        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags = implode(',', $tags);

        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount;
        $product->shipping_type = $request->shipping_type;
        if ($request->has('shipping_type')) {
            if ($request->shipping_type == 'free') {
                $product->shipping_cost = 0;
            } elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
        }
        $product->discount_type = $request->discount_type;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_img = $request->meta_img;

        if ($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if ($product->meta_description == null) {
            $product->meta_description = $product->description;
        }
        $product->pdf = $request->pdf;

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = json_encode($request->colors);
        } else {
            $colors = array();
            $product->colors = json_encode($colors);
        }

        $choice_options = array();

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;

                $item['attribute_id'] = $no;

                $data = array();
                if ($request[$str][0]) {
                    foreach (json_decode($request[$str][0]) as $key => $eachValue) {
                        array_push($data, $eachValue->value);
                    }
                    $item['values'] = $data;
                    array_push($choice_options, $item);
                }


            }
        }

        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        if (!empty($request->choice_no)) {
            $product->attributes = json_encode($request->choice_no);
        } else {
            $product->attributes = json_encode(array());
        }

        $product->choice_options = json_encode($choice_options);


        //combinations start
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }

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
        if (count($combinations[0]) > 0) {
            $product->variant_product = 1;
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $key => $item) {
                    if ($key > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = \App\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }

                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                if ($product_stock == null) {
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $product->id;
                }
                //TODO: Adding delivery logic
                $product_stock->delivery_group_id=1;
                //TODO: Adding currency logic
                $product_stock->currency_id=1;
                $product_stock->user_id=Auth::user()->id;
                $product_stock->variant = $str;
                $product_stock->price = $request['price_' . str_replace('.', '_', $str)];
                $product_stock->sku = $request['sku_' . str_replace('.', '_', $str)];
                $product_stock->qty = $request['qty_' . str_replace('.', '_', $str)];

                $product_stock->save();
            }
        } else {
            $product_stock = new ProductStock;
            //TODO: Adding delivery logic
            $product_stock->delivery_group_id=1;
            //TODO: Adding currency logic
            $product_stock->currency_id=1;
            $product_stock->user_id=Auth::user()->id;
            $product_stock->product_id = $product->id;
            $product_stock->price = $request->unit_price;
            $product_stock->qty = $request->current_stock;
            $product_stock->save();
        }

        $product->save();

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->unit = $request->unit;
        $product_translation->description = $request->description;
        $product_translation->save();

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
        $product = Product::findOrFail($id);
        foreach ($product->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }
        if (Product::destroy($id)) {

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller.products');
            }
        } else {
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
            $choice_option_list = json_decode($element->choice_options, true);
            $color_list = json_decode($element->colors, true);
            $variations=array();
            if($choice_option_list!=null && is_array($choice_option_list)){
                foreach ($choice_option_list as $index=>$attributes){
                    foreach ($attributes as $attribute_id=>$values) {
                        if($attribute = Attribute::find($attribute_id)){
                            if($attribute->combination==true){
                                $characteristics = Characteristic::whereIn('id', $values)->pluck('name')->toArray();
                                $variations[] = $characteristics;
                            }
                        }
                    }
                }
            }
            if($color_list!=null && is_array($color_list)){
                $colors=Color::whereIn('code', $color_list)->pluck('name')->toArray();
                $variations[]=$colors;
            }
            $combinations = Combinations::makeCombinations($variations);
            $lang=default_language();
            return view('backend.product.products.design_make_combination', compact('combinations', 'element', 'lang'));

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
