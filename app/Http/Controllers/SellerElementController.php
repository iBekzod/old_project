<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Characteristic;
use App\Color;
use App\ElementTranslation;
use App\Brand;
use App\Variation;
use App\Http\HelperClasses\Combinations;
use App\AttributeValue;
use App\Attribute;
use Illuminate\Http\Request;
use App\Product;
use App\Element;
use App\ProductTranslation;
use App\ProductStock;
use App\Category;
use App\Currency;
use App\Language;
use Auth;
use App\SubSubCategory;
use Session;
use ImageOptimizer;
use DB;
use Illuminate\Support\Str;
use Artisan;
use App\Product_Warehouse;
use App\VariationTranslation;
use App\Warehouse;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class SellerElementController extends Controller
{
    public function changeOnModerationAccept(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        $element->update([
            'on_moderation' => 0,
            'is_accepted' => 1
        ]);

        return redirect()->route('seller.elements.manage');
    }

    public function changeOnModerationRefuse(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        $element->update([
            'on_moderation' => 0,
            'is_accepted' => 0
        ]);

        return redirect()->route('seller.elements.manage');
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

    public function make_attribute_options(Request $request)
    {
        try {
            if ($request->method() == 'GET') {

                $category = Category::findOrFail($request->category_id);
                $element_attributes = $category->attributes;
                $data = null;
                $options = null;
                foreach ($element_attributes as $attribute) {
                        $options = $options . ' <option selected';
                        // if ($request->has('id') && $element->characteristics != null && in_array($value->id, json_decode($element->characteristics, true))) {
                        //     $options = $options . 'selected';
                        // }
                        $options = $options . ' value = "' . $attribute->id . '" > ' . $attribute->getTranslation('name', $request->lang) . ' </option >';
                }
                $data = $options;
                return response()->json(['success' => true, 'message' => 'done', 'data' => $data]);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
        return response()->json(['success' => false, 'message' => 'server']);
    }
    public function make_selected_attribute_options(Request $request)
    {
        try {
            if ($request->method() == 'GET') {
                $data=null;
                if ($request->has('selected_attribute_ids')) {
                    $selected_attribute_ids=$request->selected_attribute_ids;
                    $selected_attributes= Attribute::whereIn('id', $selected_attribute_ids)->get();
                    $content = null;
                    foreach($selected_attributes as $attribute){
                        $content = $content . '<input type="hidden" name="choice_options[' . $attribute->id . ']" value="' . $attribute->id . '">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"  for="signinSrEmail">' . $attribute->getTranslation('name', $request->lang) . '</label>
                                <div class="col-md-8">
                                    <select class="form-control js-example-basic-multiple" onchange="update_attribute_combination()" id="choice_option_' . $attribute->id . '" multiple name="choice_options[' . $attribute->id . '][]">';

                        $options = null;
                        foreach ($attribute->characteristics as $value) {
                            $options = $options . '<option selected  data-id="'.$value->id.'" ';
                            // if ($request->has('id') && $element->characteristics != null && in_array($value->id, json_decode($element->characteristics, true))) {
                            //     $options = $options . 'selected';
                            // }
                            $options = $options . ' value = "' . $value->id . '" > ' . $value->getTranslation('name',$request->lang) . ' </option >';
                        }

                        $content = $content . $options . '</select>
                                </div>
                            </div>';
                    }

                    $data=$content;
                }
                return response()->json(['success' => true, 'message' => 'done', 'data' => $data]);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
        return response()->json(['success' => false, 'message' => 'server']);
    }
    public function make_color_options(Request $request)
    {
        try {
            if ($request->method() == 'GET'){
                $data=null;
                if ($request->has('colors')){
                    $color_ids=$request->colors;
                    $selected_colors= Color::whereIn('id', $color_ids)->get();
                    $options = null;
                    foreach($selected_colors as $color){
                        $options = $options .'<option selected value="'.$color->id.'" data-id="'.$color->id.'" value="" data-content="<span><span class=\'mr-2 border rounded size-15px d-inline-block\' style=\'background:'.$color->code.'\'></span><span>'.$color->name.'</span></span>"></option>';
                    }
                    $data=$options;
                }
                return response()->json(['success' => true, 'message' => 'done', 'data' => $data]);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
        return response()->json(['success' => false, 'message' => 'server']);
    }
    public function make_attribute_variations(Request $request)
    {
        try {
            if ($request->method() == 'GET'){
                $data=null;
                if ($request->has('selected_attribute_ids')){
                    $selected_attribute_ids=$request->selected_attribute_ids;
                    $selected_attributes= Attribute::whereIn('id', $selected_attribute_ids)->where('combination','=', 1)->get();
                    $options = null;
                    foreach($selected_attributes as $attribute){
                        $options = $options .'<option selected value="'.$attribute->id.'" data-id="'.$attribute->id.'" >'.$attribute->getTranslation('name',$request->lang).'</option>';
                    }
                    $data=$options;
                }
                return response()->json(['success' => true, 'message' => 'done', 'data' => $data]);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
        return response()->json(['success' => false, 'message' => 'server']);
    }

    public function make_all_combination(Request $request)
    {
       try {
            if ($request->method() == 'GET'){
                $data=null;
                $variations=[];
                if ($request->has('choice_groups')){
                    foreach ($request->choice_groups as $value_ids){
                        $selected_attributes = Characteristic::whereIn('id', $value_ids)->pluck('name')->toArray();
                        $variations[]=$selected_attributes;
                    }
                }
                if ($request->has('color_ids')){
                    $color_ids=$request->color_ids;
                    $selected_colors = Color::whereIn('id', $color_ids)->pluck('name')->toArray();
                    $variations[]=$selected_colors;
                }
                $combinations = Combinations::makeCombinations($variations);

                $content=null;
                $content=$content.'
                <div style="overflow-y: scroll; ">
                    <table class="table table-bordered" >
                        <thead>
                        <tr>
                            <td class="text-center">
                                <label for="" class="control-label">'.translate('#').'</label>
                            </td>
                            <td class="text-center">
                                <label class="col-form-label" for="signinSrEmails">'.translate('Variation Image').'
                                        <small>(290x300)</small></label>
                            </td>
                            <td class="text-center">
                                <label for="" class="control-label">'.translate('Name').'</label>
                            </td>
                            <td class="text-center">
                                <label for="" class="control-label">'.translate('Artikul').'</label>
                            </td>
                            <td class="text-center">
                                <label for="" class="control-label">'.translate('Delete').'</label>
                            </td>

                        </tr>
                        </thead>
                        <tbody>';
                foreach ($combinations as $index=>$combination){
                    $content=$content.'
                        <tr class="variant">
                            <td>
                                <label for="" class="control-label">'.($index+1).'</label>
                            </td>
                            <td>
                                <div class="form-group">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text bg-soft-secondary font-weight-medium">'.translate('Browse').'</div>
                                            </div>
                                            <div class="form-control file-amount"></div>
                                            <input type="hidden" name="combination['.$index.'][thumbnail_img]" value=""
                                                   class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                </div>
                            </td>
                            <td>
                                <label for="" class="control-label">'.implode (",", $combination).'</label>
                                <input type="hidden" name="combination['.$index.'][name]" value="'.implode (",", $combination).'" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="combination['.$index.'][artikul]" value="" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variant(this)"><i class="las la-trash"></i></button>
                            </td>
                        </tr>
                        ';
                }
                $content=$content.'</tbody>
                    </table>
                </div>
                ';
                $data=$content;
                return response()->json(['success' => true, 'message' => $combinations, 'data' => $data]);
            }
       } catch (\Exception $exception) {
           return response()->json(['success' => false, 'message' => $exception->getMessage()]);
       }
        return response()->json(['success' => false, 'message' => 'server']);
    }


    // public function make_choice_options(Request $request)
    // {
    //     try {
    //         if ($request->method() == 'GET') {
    //             if ($request->has('id')) {
    //                 $element = Element::where('id', $request->id)->firstOrFail();
    //             }

    //             $category = Category::findOrFail($request->category_id);
    //             $element_attributes = $category->attributes->groupBy('branch_id');
    //             $data = null;
    //             foreach ($element_attributes as $branch => $attributes) {
    //                 $data = $data . '<div class="card">
    //                                     <div class="card-header">
    //                                         <h5 class="mb-0 h6">' . Branch::where('id', $branch)->first()->getTranslation('name',$request->lang) . '</h5>
    //                                     </div>
    //                                     <div class="card-body">';
    //                 $content = null;
    //                 foreach ($attributes as $attribute) {
    //                     $content = $content . '<input type="hidden" name="choice_options[' . $attribute->id . ']" value="' . $attribute->id . '">
    //                         <div class="form-group row">
    //                             <label class="col-md-3 col-form-label"  for="signinSrEmail">' . $attribute->getTranslation('name',$request->lang) . '</label>
    //                             <div class="col-md-8">
    //                                 <select class="form-control js-example-basic-multiple"  multiple name="choice_options[' . $attribute->id . '][]">';

    //                     $options = null;
    //                     foreach ($attribute->characteristics as $value) {
    //                         $options = $options . '<option';
    //                         if ($request->has('id') && $element->characteristics != null && in_array($value->id, json_decode($element->characteristics, true))) {
    //                             $options = $options . 'selected';
    //                         }
    //                         $options = $options . ' value = "' . $value->id . '" > ' . $value->getTranslation('name',$request->lang) . ' </option >';
    //                     }

    //                     $content = $content . $options . '</select>
    //                             </div>
    //                         </div>';
    //                 }
    //                 $data = $data . $content . '</div>
    //                             </div>';
    //             }
    //             return response()->json(['success' => true, 'message' => 'get', 'data' => $data]);
    //         }
    //     } catch (\Exception $exception) {
    //         return response()->json(['success' => false, 'message' => $exception->getMessage()]);
    //     }
    //     return response()->json(['success' => false, 'message' => 'server']);
    // }

    public function remove_variation(Request $request){
        if($variation=Variation::findOrFail($request->id)){
            $variation->delete();
            return response()->json(['success' => true, 'message' => 'server']);
        }
        return response()->json(['success' => false, 'message' => 'server']);
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
        return view('frontend.user.seller.elements.index', compact('elements', 'type', 'col_name', 'query', 'sort_search'));
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
        $elements = Element::where('added_by', 'admin');
        // if ($request->has('user_id') && $request->user_id != null) {
        //     $elements = $elements->where('user_id', $request->user_id);
        //     $seller_id = $request->user_id;
        // }
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

        $elements = $elements
        // ->where('digital', 0)
        ->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('frontend.user.seller.elements.index', compact('elements', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
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

        return view('frontend.user.seller.elements.index', compact('elements', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $categories = Category::withDepth()->having('depth', '=', 2)->get();
        $brands = Brand::all();
        return view('frontend.user.seller.elements.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $element = new Element;
        $element->added_by = $request->added_by;
        $element->category_id = $request->category_id;
        $element->brand_id = $request->brand_id;
        $element->barcode = $request->barcode;
        $choice_options = $request->choice_options;

        $generated_variations = array();
        $my_characteristics = array();
        $my_variations = array();
        $variation_attributes = array();
        $variation_values = array();
        if($request->has('collected_variations'))$variation_values = explode(",", $request->collected_variations[0]);
        if($request->has('selected_variations'))$variation_attributes = $request->selected_variations;

        if ($choice_options) {
            foreach ($choice_options as $attribute => $values) {
                if (is_array($values)) {
                    $my_characteristics[$attribute] =$values;
                    if(in_array($attribute, $variation_attributes)){
                        $my_values=array();
                        foreach ($values as $value) {
                            if(in_array($value, $variation_values)){
                                $my_values[] = $value;
                            }
                        }
                        $my_variations[$attribute] = $my_values;
                    }
                }
            }
        }
        // dd($my_variations);
        // if ($request->has('combination')) {
        //     foreach ($request->combination as $variant) {
        //         $generated_variations[]=[
        //             "image"=>$variant["thumbnail_img"],
        //             "name"=>$variant["name"],
        //             "artikul"=>$variant["name"],
        //         ];
        //     }
        // }
        $element->characteristics = json_encode($my_characteristics ?? array());
        $element->variations = json_encode($my_variations ?? array());
        $element->variation_attributes = json_encode($request->selected_variations ?? array());
        $element->variation_colors = json_encode($request->colors ?? array());

        $element->name = $request->name;
        $element->unit = $request->unit;
        $element->description = $request->description;
        $element->slug = SlugService::createSlug(Element::class, 'slug', slugify($request->name));
        $element->photos = $request->photos;
        $element->thumbnail_img = $request->thumbnail_img;
        // $tags = array();
        // if ($request->tags != null) {
        //     foreach (json_decode($request->tags[0], true) as $key => $tag) {
        //         $tags[] = $tag["value"];
        //     }
        // }
        // $element->tags = json_encode($tags ?? array());;
        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $element->tags = implode(',', $tags);
        $element->video_provider = $request->video_provider;
        $element->video_link = $request->video_link;
        $element->meta_title = $request->meta_title;
        $element->meta_description = $request->meta_description;
        $element->meta_img = $request->meta_img;

        if (Auth::user()->user_type == 'seller') {
            $element->user_id = Auth::user()->id;
        } else {
            $element->user_id = \App\User::where('user_type', 'admin')->first()->id;
        }
        if ($element->meta_title == null) {
            $element->meta_title = $element->name;
        }

        if ($element->meta_description == null) {
            $element->meta_description = $element->description;
        }
        $element->pdf = $request->pdf;
        if($element->save()){
            if ($request->has('combination')) {
                foreach ($request->combination as $variant) {
                    if(Variation::where('name', $variant['name'])->where('element_id', $element->id)->where('user_id', Auth::user()->id)->first())
                    {
                        continue;
                    }
                    $variation= new Variation;
                    $variation->element_id=$element->id;
                    $variation->name=$element->name." ".$variant['name'];
                    $variation->thumbnail_img = $variant['thumbnail_img'];
                    $variation->slug = SlugService::createSlug(Variation::class, 'slug', slugify($variant['name']));
                    $variation->sku=$variant['artikul'];
                    $variation->num_of_sale=0;
                    $variation->qty=0;
                    $variation->rating=0;
                    $variation->user_id=Auth::user()->id;
                    $variation->save();
                    foreach (Language::all() as $language) {
                        $variation_translation = VariationTranslation::firstOrNew(['lang' => $language->code, 'variation_id' => $variation->id]);
                        $variation_translation->name = $variation->name;
                        $variation_translation->save();
                    }
                }
            }
            foreach (Language::all() as $language){
                // Element Translations
                $element_translation = ElementTranslation::firstOrNew(['lang' => $language->code, 'element_id' => $element->id]);
                $element_translation->name = $request->name;
                $element_translation->unit = $request->unit;
                $element_translation->description = $request->description;
                $element_translation->save();
            }
        }

        flash(translate('Element has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        if (Auth::user()->user_type == 'seller' || Auth::user()->user_type == 'staff') {
            return redirect()->route('seller.elements.seller');
        } else {
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                $seller = Auth::user()->seller;
                $seller->remaining_uploads -= 1;
                $seller->save();
            }
            return redirect()->route('seller.elements.seller');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function admin_element_edit(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        // ($element->category) ? $element_attributes = $element->category->attributes->groupBy('branch_id') : $element_attributes = [];
        $lang = $request->lang;
        $tags = json_decode($element->tags);
        $variation_colors = json_decode($element->variation_colors);
        $variation_attributes = json_decode($element->variation_attributes, true);
        $variations = json_decode($element->variations, true);
        $characteristics = json_decode($element->characteristics, true);
        $categories = Category::withDepth()->having('depth', '=', 2)->get();
        $brands = Brand::all();
        $colors = Color::all();
        // dd( $element->combinations );
        return view('frontend.user.seller.elements.edit', compact('element', 'colors','variations', 'variation_colors', 'variation_attributes', 'categories', 'tags', 'lang', 'characteristics', 'brands'));
    }

    public function seller_element_edit(Request $request, $id)
    {
        $this->admin_element_edit($request, $id);
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

        $element = Element::findOrFail($id);
        $element->category_id = $request->category_id;
        $element->brand_id = $request->brand_id;
        $element->barcode = $request->barcode;
        $choice_options = $request->choice_options;

        $my_characteristics = array();
        $my_variations = array();
        $variation_attributes = array();
        $variation_values = array();
        if($request->has('collected_variations'))$variation_values = explode(",", $request->collected_variations[0]);
        if($request->has('selected_variations'))$variation_attributes = $request->selected_variations;

        if ($choice_options) {
            foreach ($choice_options as $attribute => $values) {
                if (is_array($values)) {
                    $my_characteristics[$attribute] =$values;
                    if(in_array($attribute, $variation_attributes)){
                        $my_values=array();
                        foreach ($values as $value) {
                            if(in_array($value, $variation_values)){
                                $my_values[] = $value;
                            }
                        }
                        $my_variations[$attribute] = $my_values;
                    }
                }
            }
        }
        $element->characteristics = json_encode($my_characteristics ?? array());
        $element->variations = json_encode($my_variations ?? array());
        $element->variation_attributes = json_encode($request->selected_variations ?? array());
        $element->variation_colors = json_encode($request->colors ?? array());

        $element->name = $request->name;
        $element->unit = $request->unit;
        $element->description = $request->description;
        if ($request->name != null) {
            if($element->slug!=$request->slug)
                $element->slug = SlugService::createSlug(Element::class, 'slug', slugify($request->name));
        }
        $element->photos = $request->photos;
        $element->thumbnail_img = $request->thumbnail_img;
        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $element->tags = implode(',', $tags);
        $element->video_provider = $request->video_provider;
        $element->video_link = $request->video_link;
        $element->meta_title = $request->meta_title;
        $element->meta_description = $request->meta_description;
        $element->meta_img = $request->meta_img;

        if (Auth::user()->user_type == 'seller') {
            $element->user_id = Auth::user()->id;
        } else {
            $element->user_id = \App\User::where('user_type', 'admin')->first()->id;
        }
        if ($element->meta_title == null) {
            $element->meta_title = $element->name;
        }

        if ($element->meta_description == null) {
            $element->meta_description = $element->description;
        }
        $element->pdf = $request->pdf;
        if($element->save()){
            if ($request->has('combination')) {
                if($request->is_new_combination){
                    Variation::where('element_id', $element->id)->where('user_id', Auth::user()->id)->delete();
                    foreach ($request->combination as $variant) {
                        $variation= new Variation;
                        $variation->element_id=$element->id;
                        $variation->name=$element->name." ".$variant['name'];
                        $variation->thumbnail_img = $variant['thumbnail_img'];
                        $variation->slug = SlugService::createSlug(Variation::class, 'slug', slugify($variant['name']));
                        $variation->sku=$variant['artikul'];
                        $variation->num_of_sale=0;
                        $variation->qty=0;
                        $variation->rating=0;
                        $variation->user_id=Auth::user()->id;
                        $variation->save();
                    }
                }else{
                    $variations= Variation::where('element_id', $element->id)->where('user_id', Auth::user()->id);
                    foreach ($request->combination as $variant) {
                        if($variation=$variations->where('name', $variant['name'])->firstOrFail()){
                            $variation->name=$element->name." ".$variant['name'];
                            $variation->thumbnail_img = $variant['thumbnail_img'];
                            if ($variant['name'] != null) {
                                if($variation->slug!=$variant['name'])
                                    $variation->slug = SlugService::createSlug(Variation::class, 'slug', slugify($variant['name']));
                            }
                            $variation->sku=$variant['artikul'];
                            $variation->user_id=Auth::user()->id;
                            $variation->save();
                        }else{
                            $variation= new Variation;
                            $variation->element_id=$element->id;
                            $variation->name=$element->name." ".$variant['name'];
                            $variation->thumbnail_img = $variant['thumbnail_img'];
                            $variation->slug = SlugService::createSlug(Variation::class, 'slug', slugify($variant['name']));
                            $variation->sku=$variant['artikul'];
                            $variation->num_of_sale=0;
                            $variation->qty=0;
                            $variation->rating=0;
                            $variation->user_id=Auth::user()->id;
                            $variation->save();
                        }
                        foreach (Language::all() as $language) {
                            $variation_translation = VariationTranslation::firstOrNew(['lang' => $language->code, 'variation_id' => $variation->id]);
                            $variation_translation->name = $variation->name;
                            $variation_translation->save();
                        }

                    }
                }
            }
            foreach (Language::all() as $language){
                // Element Translations
                $element_translation = ElementTranslation::firstOrNew(['lang' => $language->code, 'element_id' => $element->id]);
                $element_translation->name = $request->name;
                $element_translation->unit = $request->unit;
                $element_translation->description = $request->description;
                $element_translation->save();
            }
        }


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
                return redirect()->route('seller.elements.admin');
            } else {
                return redirect()->route('seller.seller.elements');
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


    // public function variantProducts(Request $request){
    //     if($variation = Variation::findOrFail($request->id)){
    //         $products = $variation->products;
    //         $lang = default_language();
    //         $currencies = Currency::where('status', true)->get();
    //         return view('backend.product.products.edit', compact('variation', 'products', 'currencies', 'lang'));
    //     }
    //     return back();
    // }

    public function elementProducts(Request $request){
        $element = Element::findOrFail($request->id);
        $combinations=Variation::where('element_id', $element->id);
        $variation_ids=$combinations->pluck('id');
        if(count($variation_ids)>0){
            $lang = default_language();
            $currencies = Currency::where('status', true)->get();
            if(Product::where('user_id', auth()->id())->whereIn('variation_id', $variation_ids)->exists()){
                $products=Product::where('user_id', auth()->id())->whereIn('variation_id', $variation_ids)->get();
                return view('frontend.user.seller.products.edit_product', compact('element', 'products', 'currencies', 'lang'));
            }
            $combinations=$combinations->get();
            return view('frontend.user.seller.products.create_product', compact('element', 'combinations', 'currencies', 'lang'));
        }
        return back();
    }
}
