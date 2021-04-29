<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\HelperClasses\Combinations;
use App\AttributeValue;
use App\Attribute;
use Illuminate\Http\Request;
use App\Product;
use App\Element;
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


class ElementController extends Controller
{
    public function changeOnModerationAccept(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        $element->update([
            'on_moderation' => 0,
            'is_accepted' => 1
        ]);

        return redirect()->route('elements.manage');
    }

    public function changeOnModerationRefuse(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        $element->update([
            'on_moderation' => 0,
            'is_accepted' => 0
        ]);

        return redirect()->route('elements.manage');
    }

    public function manageProducts(Request $request)
    {
        $elements = Element::where('is_accepted', 1)->latest()->paginate(10);
        $type = 'Seller';

        return view('backend.product.manage', [
            'elements' => $elements,
            'type' => $type
        ]);
    }

    public function make_choice_options(Request $request, $id){
        try {
            if($request->method()=='POST'){
                $element = Element::where('id', $id)->firstOrFail();
                $choice_options=json_decode($request->choice_options, true);
                $element->attributes->sync([]);
                $element->characteristics->sync([]);
                $element->choice_options->sync([]);
                foreach($choice_options as $attribute=>$values){
                    $element->attributes->attach($attribute);
                    foreach ($values as $value){
                        $element->characteristics->attach($value);
                    }
                    $element->choice_options=$request->choice_options;
                }
                flash(translate('Saved successfully'))->success();
                return response()->json(['success'=>true, 'message'=>'post']);
            }else if($request->method()=='GET'){
                $element = Element::where('id', $id)->firstOrFail();
                $options = $element->choice_options;
                return response()->json(['success'=>true, 'message'=>'get']);
            }
        }catch (\Exception $exception){
            return response()->json(['success'=>false, 'message'=>$exception->getMessage()]);
        }
        return response()->json(['success'=>false, 'message'=>'server']);
    }

    public function getAttributesByCategory($id){
        $category = Category::firstOrFail($id);
        if($category!=mull){
            $attrinutes=$category->attributes;
        }
        return response()->json([
            'attributes'=>$attrinutes
        ]);
    }
//    public function getAttributes(Request $request){
//        try {
//            $element = Element::where('category_id', $request->id)->firstOrFail();
//            $choice_options= $element->choice_options;
//            return response()->json(['success'=>false, 'choice_options'=>$choice_options]);
//
//        }catch (\Exception $exception){
//            return response()->json(['success'=>false, 'message'=>$exception->getMessage()]);
//        }
//        return response()->json(['success'=>false, 'message'=>'server']);
//    }

    public function characteristics(Request $request, $id)
    {
        if ($request->method() == 'POST') {
            $element = Element::where('id', $id)->firstOrFail();
            $element->characteristicValues()->delete();
            if ($request->get('attr')) {
                foreach ($request->get('attr') as $item) {
                    $data = [
                        'element_id' => $element->id,
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
            $element = Element::where('id', $id)->with(['characteristicValues'])->firstOrFail();
            $options = $element->category->attributes;
            // dd($element->characteristicValues);
            return view('backend.product.elements.add_attr', compact(
                'element', 'options'
            ));
        }
    }

    public function addInStockProductAttrs(Request $request, $id)
    {
        $element = ProductStock::where('id', $id)->firstOrFail();
        $lang = $request->get('lang');
        $options = ProductAttribute::all();

        return view('backend.product.elements.add_attr', [
            'element' => $element,
            'lang' => $lang,
            'options' => $options
        ]);
    }

    public function inStock($id)
    {
        $element = Element::where('id', $id)->firstOrFail();
        $type = 'All';

        return view('backend.product.elements.in_stock', [
            'element' => $element,
            'elements' => $element->stocks()->paginate(15),
            'type' => $type
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_elements(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();

        $type = 'In House';
        $col_name = null;
        $query = null;
        $sort_search = null;

        $elements = Element::where('added_by', 'admin');

        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $elements = $elements->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null) {
            $elements = $elements
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $elements = $elements->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.product.elements.index', compact('elements', 'type', 'col_name', 'query', 'sort_search'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_elements(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $elements = Element::where('added_by', 'seller');
        if ($request->has('user_id') && $request->user_id != null) {
            $elements = $elements->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $elements = $elements
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $elements = $elements->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $elements = $elements->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('backend.product.elements.index', compact('elements', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    public function all_elements(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $elements = Element::orderBy('created_at', 'desc');
        if ($request->has('user_id') && $request->user_id != null) {
            $elements = $elements->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $elements = $elements
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $elements = $elements->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $elements = $elements->paginate(15);
        $type = 'All';

        return view('backend.product.elements.index', compact('elements', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
//        dd(Category::withDepth()->having('depth', '=', 3)->get());
//        $data = [
//            'categories' => Category::where('level', '>=', 2)->get(),
//            'brands' => Brand::all()
//        ];
        $data = [
            'categories' => Category::withDepth()->having('depth', '=', 2)->get(),
            'brands' => Brand::all()
        ];

        return view('backend.product.elements.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();

        $element = new Element;
        $element->name = $request->name;
        $element->added_by = $request->added_by;
        if (Auth::user()->user_type == 'seller') {
            $element->user_id = Auth::user()->id;
        } else {
            $element->user_id = \App\User::where('user_type', 'admin')->first()->id;
        }
        $element->subsubcategory_id = $request->category_id;
        $element->brand_id = $request->brand_id;
        $element->current_stock = $request->current_stock;
        $element->barcode = $request->barcode;

        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $element->refundable = 1;
            } else {
                $element->refundable = 0;
            }
        }
        $element->photos = $request->photos;
        $element->thumbnail_img = $request->thumbnail_img;
        $element->unit = $request->unit;
        $element->min_qty = $request->min_qty;

        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $element->tags = implode(',', $tags);

        $element->description = $request->description;
        $element->video_provider = $request->video_provider;
        $element->video_link = $request->video_link;
        $element->unit_price = $request->unit_price;
        $element->purchase_price = $request->purchase_price;
        $element->tax = $request->tax;
        $element->tax_type = $request->tax_type;
        $element->discount = $request->discount;
        $element->discount_type = $request->discount_type;
        $element->shipping_type = $request->shipping_type;

        if ($request->has('shipping_type')) {
            if ($request->shipping_type == 'free') {
                $element->shipping_cost = 0;
            } elseif ($request->shipping_type == 'flat_rate') {
                $element->shipping_cost = $request->flat_shipping_cost;
            }
        }
        $element->meta_title = $request->meta_title;
        $element->meta_description = $request->meta_description;

        if ($request->has('meta_img')) {
            $element->meta_img = $request->meta_img;
        } else {
            $element->meta_img = $element->thumbnail_img;
        }

        if ($element->meta_title == null) {
            $element->meta_title = $element->name;
        }

        if ($element->meta_description == null) {
            $element->meta_description = $element->description;
        }

        if ($request->hasFile('pdf')) {
            $element->pdf = $request->pdf->store('uploads/elements/pdf');
        }

        // $element->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $element->slug = SlugService::createSlug(Element::class, 'slug', slugify($request->name));

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $element->colors = json_encode($request->colors);
        } else {
            $colors = array();
            $element->colors = json_encode($colors);
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

        if (!empty($request->choice_no)) {
            $element->attributes = json_encode($request->choice_no);
        } else {
            $element->attributes = json_encode(array());
        }

        $element->choice_options = json_encode($choice_options);

        //$variations = array();

        $element->save();

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
                if ($request[$name][0]) {
                    foreach (json_decode($request[$name][0]) as $key => $item) {
                        array_push($data, $item->value);
                    }
                    array_push($options, $data);

                }

            }
        }

        //Generates the combinations of customer choice options
        $combinations = Combinations::makeCombinations($options);
        if (count($combinations[0]) > 0) {
            $element->variant_element = 1;
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
                $element_stock = ProductStock::where('element_id', $element->id)->where('variant', $str)->first();
                if ($element_stock == null) {
                    $element_stock = new ProductStock;
                    $element_stock->element_id = $element->id;
                }
                //TODO: Adding delivery logic
                $element_stock->delivery_group_id=1;
                //TODO: Adding currency logic
                $element_stock->currency_id=1;
                $element_stock->user_id=Auth::user()->id;
                $element_stock->variant = $str;
                $element_stock->price = $request['price_' . str_replace('.', '_', $str)];
                $element_stock->sku = $request['sku_' . str_replace('.', '_', $str)];
                $element_stock->qty = $request['qty_' . str_replace('.', '_', $str)];
                $element_stock->save();
            }
        } else {
            $element_stock = new ProductStock;
            $element_stock->element_id = $element->id;

            //TODO: Adding delivery logic
            $element_stock->delivery_group_id=1;
            //TODO: Adding currency logic
            $element_stock->currency_id=1;
            $element_stock->user_id=Auth::user()->id;

            $element_stock->price = $request->unit_price;
            $element_stock->qty = $request->current_stock;
            $element_stock->save();
        }
        //combinations end

        $element->save();

        // Element Translations
        $element_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'element_id' => $element->id]);
        $element_translation->name = $request->name;
        $element_translation->unit = $request->unit;
        $element_translation->description = $request->description;
        $element_translation->save();

        flash(translate('Element has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return redirect()->route('elements.admin');
        } else {
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= 1;
                $seller->save();
            }
            return redirect()->route('seller.elements');
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
    public function admin_element_edit(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        ($element->category)? $element_attributes = $element->category->attributes : $element_attributes = [];
        $lang = $request->lang;
        $tags = json_decode($element->tags);
        $categories = Category::all()->toTree();

        // return view('backend.product.elements.edit', compact('element', 'categories', 'tags', 'lang', 'elementAttributes', 'selectedProductAttributes'));
        return view('backend.product.elements.edit', compact('element', 'categories', 'tags', 'lang', 'element_attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function seller_element_edit(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($element->tags);
        $categories = Category::all()->toTree();
        return view('backend.product.elements.edit', compact('element', 'categories', 'tags', 'lang'));
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
        $element = Element::findOrFail($id);
        $element->elementAttributes()->detach();
        $element->elementAttributes()->attach($request->get('attrs'));
        $element->subsubcategory_id = $request->category_id;
        $element->brand_id = $request->brand_id;
        $element->current_stock = $request->current_stock;
        $element->barcode = $request->barcode;


        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $element->refundable = 1;
            } else {
                $element->refundable = 0;
            }
        }

        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $element->name = $request->name;
            $element->unit = $request->unit;
            $element->description = $request->description;
            if($element->slug!=$request->slug)
                $element->slug = SlugService::createSlug(Element::class, 'slug', slugify($request->name));
        }

        $element->photos = $request->photos;
        $element->thumbnail_img = $request->thumbnail_img;
        $element->min_qty = $request->min_qty;

        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $element->tags = implode(',', $tags);

        $element->video_provider = $request->video_provider;
        $element->video_link = $request->video_link;
        // $element->unit_price = $request->unit_price;
        // $element->purchase_price = $request->purchase_price;
        // $element->tax = $request->tax;
        // $element->tax_type = $request->tax_type;
        // $element->discount = $request->discount;
        // $element->shipping_type = $request->shipping_type;
        // if ($request->has('shipping_type')) {
        //     if ($request->shipping_type == 'free') {
        //         $element->shipping_cost = 0;
        //     } elseif ($request->shipping_type == 'flat_rate') {
        //         $element->shipping_cost = $request->flat_shipping_cost;
        //     }
        // }
        // $element->discount_type = $request->discount_type;
        $element->meta_title = $request->meta_title;
        $element->meta_description = $request->meta_description;
        $element->meta_img = $request->meta_img;
        $element->added_by=Auth::user()->id;
        if ($element->meta_title == null) {
            $element->meta_title = $element->name;
        }

        if ($element->meta_description == null) {
            $element->meta_description = $element->description;
        }
        $element->pdf = $request->pdf;

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $element->colors = json_encode($request->colors);
        } else {
            $colors = array();
            $element->colors = json_encode($colors);
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

        foreach ($element->stocks as $key => $stock) {
            $stock->delete();
        }

        if (!empty($request->choice_no)) {
            $element->attributes = json_encode($request->choice_no);
        } else {
            $element->attributes = json_encode(array());
        }

        $element->choice_options = json_encode($choice_options);


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
            $element->variant_element = 1;
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

                $element_stock = ProductStock::where('element_id', $element->id)->where('variant', $str)->first();
                if ($element_stock == null) {
                    $element_stock = new ProductStock;
                    $element_stock->element_id = $element->id;
                }
                //TODO: Adding delivery logic
                // $element_stock->delivery_group_id=1;
                //TODO: Adding currency logic
                // $element_stock->currency_id=1;
//                $element_stock->user_id=Auth::user()->id;
//                $element_stock->variant = $str;
//                $element_stock->price = $request['price_' . str_replace('.', '_', $str)];
//                $element_stock->sku = $request['sku_' . str_replace('.', '_', $str)];
//                $element_stock->qty = $request['qty_' . str_replace('.', '_', $str)];
//
//                $element_stock->save();
            }
        } else {
            // $element_stock = new ProductStock;
            // //TODO: Adding delivery logic
            // $element_stock->delivery_group_id=1;
            // //TODO: Adding currency logic
            // $element_stock->currency_id=1;
            // $element_stock->user_id=Auth::user()->id;
            // $element_stock->element_id = $element->id;
            // $element_stock->price = $request->unit_price;
            // $element_stock->qty = $request->current_stock;
            // $element_stock->save();
        }

        $element->save();

        // Element Translations
        $element_translation = ProductTranslation::firstOrNew(['lang' => $request->lang, 'element_id' => $element->id]);
        $element_translation->name = $request->name;
        $element_translation->unit = $request->unit;
        $element_translation->description = $request->description;
        $element_translation->save();

        flash(translate('Element has been updated successfully'))->success();

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
        $element = Element::findOrFail($id);
        foreach ($element->element_translations as $key => $element_translations) {
            $element_translations->delete();
        }
        if (Element::destroy($id)) {

            flash(translate('Element has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('elements.admin');
            } else {
                return redirect()->route('seller.elements');
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
        $element = Element::find($id);
        $element_new = $element->replicate();
        // $element_new->slug = substr($element_new->slug, 0, -5) . Str::random(5);
        if ($element_new->save()) {
            flash(translate('Element has been duplicated successfully'))->success();
            if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
                if ($request->type == 'In House')
                    return redirect()->route('elements.admin');
                elseif ($request->type == 'Seller')
                    return redirect()->route('elements.seller');
                elseif ($request->type == 'All')
                    return redirect()->route('elements.all');
            } else {
                return redirect()->route('seller.elements');
            }
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_elements_by_brand(Request $request)
    {
        $elements = Element::where('brand_id', $request->brand_id)->get();
        return view('partials.element_select', compact('elements'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $element = Element::findOrFail($request->id);
        $element->todays_deal = $request->status;
        if ($element->save()) {
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $element = Element::findOrFail($request->id);
        $element->published = $request->status;
        $element->on_moderation = 1;

        if ($element->added_by == 'seller' && \App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            $seller = $element->user->seller;
            if ($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0) {
                return 0;
            }
        }

        $element->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $element = Element::findOrFail($request->id);
        $element->featured = $request->status;
        if ($element->save()) {
            return 1;
        }
        return 0;
    }

    public function updateSellerFeatured(Request $request)
    {
        $element = Element::findOrFail($request->id);
        $element->seller_featured = $request->status;
        if ($element->save()) {
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $element_name = $request->name;

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
        return view('backend.product.elements.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'element_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $element = Element::findOrFail($request->id);

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $element_name = $request->name;
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
        return view('backend.product.elements.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'element_name', 'element'));
    }

    public function elementWarehouseData($id)
    {
        $warehouse = [];
        $qty = [];
        $warehouse_name = [];
        $variant_name = [];
        $variant_qty = [];
        $element_warehouse = [];
        $element_variant_warehouse = [];
        $lims_element_data = Element::select('id', 'is_variant')->find($id);
        // if($lims_element_data->is_variant) {
        //     $lims_element_variant_warehouse_data = Product_Warehouse::where('element_id', $lims_element_data->id)->orderBy('warehouse_id')->get();
        //     $lims_element_warehouse_data = Product_Warehouse::select('warehouse_id', DB::raw('sum(qty) as qty'))->where('element_id', $id)->groupBy('warehouse_id')->get();
        //     foreach ($lims_element_variant_warehouse_data as $key => $element_variant_warehouse_data) {
        //         $lims_warehouse_data = Warehouse::find($element_variant_warehouse_data->warehouse_id);
        //         $lims_variant_data = Variant::find($element_variant_warehouse_data->variant_id);
        //         $warehouse_name[] = $lims_warehouse_data->name;
        //         $variant_name[] = $lims_variant_data->name;
        //         $variant_qty[] = $element_variant_warehouse_data->qty;
        //     }
        // }
        // else{
        $lims_element_warehouse_data = Product_Warehouse::where('element_id', $id)->get();
        // }
        foreach ($lims_element_warehouse_data as $key => $element_warehouse_data) {
            $lims_warehouse_data = Warehouse::find($element_warehouse_data->warehouse_id);
            $warehouse[] = $lims_warehouse_data->name;
            $qty[] = $element_warehouse_data->qty;
        }

        $element_warehouse = [$warehouse, $qty];
        $element_variant_warehouse = [$warehouse_name, $variant_name, $variant_qty];
        return ['element_warehouse' => $element_warehouse, 'element_variant_warehouse' => $element_variant_warehouse];
    }


}
