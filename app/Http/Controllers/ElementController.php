<?php

namespace App\Http\Controllers;

use App\Branch;
use App\ElementTranslation;
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

    public function make_choice_options(Request $request)
    {
        try {
            if ($request->method() == 'GET') {
                if ($request->has('id')) {
                    $element = Element::where('id', $request->id)->firstOrFail();
                }

                $category = Category::findOrFail($request->category_id);
                $element_attributes = $category->attributes->groupBy('branch_id');
                $data = null;
                foreach ($element_attributes as $branch => $attributes) {
                    $data = $data . '<div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0 h6">' . Branch::where('id', $branch)->first()->getTranslation('name') . '</h5>
                                        </div>
                                        <div class="card-body">';
                    $content = null;
                    foreach ($attributes as $attribute) {
                        $content = $content . '<input type="hidden" name="choice_options[' . $attribute->id . ']" value="' . $attribute->id . '">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"  for="signinSrEmail">' . $attribute->getTranslation('name') . '</label>
                                <div class="col-md-8">
                                    <select class="form-control js-example-basic-multiple"  multiple name="choice_options[' . $attribute->id . '][]">';

                        $options = null;
                        foreach ($attribute->characteristics as $value) {
                            $options = $options . '<option';
                            if ($request->has('id') && $element->characteristics != null && in_array($value->id, json_decode($element->characteristics, true))) {
                                $options = $options . 'selected';
                            }
                            $options = $options . ' value = "' . $value->id . '" > ' . $value->getTranslation('name') . ' </option >';
                        }

                        $content = $content . $options . '</select>
                                </div>
                            </div>';
                    }
                    $data = $data . $content . '</div>
                                </div>';
                }
                return response()->json(['success' => true, 'message' => 'get', 'data' => $data]);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
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
        $categories = Category::withDepth()->having('depth', '=', 2)->get();
        $brands = Brand::all();
        return view('backend.product.elements.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $element = new Element;
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $element->refundable = 1;
            } else {
                $element->refundable = 0;
            }
        }
        $element->added_by = $request->added_by;
        $element->category_id = $request->category_id;
        $element->brand_id = $request->brand_id;
        $element->barcode = $request->barcode;
        $choice_options = $request->choice_options;
        $my_attributes = array();
        $my_characteristics = array();
        $my_choice_options = array();
        if ($choice_options) {
            foreach ($choice_options as $attribute => $values) {
                array_push($my_attributes, $attribute);
                if (is_array($values)) {
                    foreach ($values as $value) {
                        array_push($my_characteristics, $value);
                    }
                    array_push($my_choice_options, array($attribute => $values));
                }
            }
        }
        $element->choice_options = json_encode($my_choice_options ?? array());
        $element->attributes = json_encode($my_attributes ?? array());
        $element->characteristics = json_encode($my_characteristics ?? array());
        $element->colors = json_encode($request->colors ?? array());
//        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $element->name = $request->name;
            $element->unit = $request->unit;
            $element->description = $request->description;
            $element->slug = SlugService::createSlug(Element::class, 'slug', slugify($request->name));
//        }
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
        $element->save();
        // Element Translations
        $element_translation = ElementTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE', 'en'), 'element_id' => $element->id]);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function admin_element_edit(Request $request, $id)
    {
        $element = Element::findOrFail($id);
        ($element->category) ? $element_attributes = $element->category->attributes->groupBy('branch_id') : $element_attributes = [];
        $lang = $request->lang;
        $tags = json_decode($element->tags);
        $colors = json_decode($element->colors);
        $choice_options = json_decode($element->choice_options);
        $categories = Category::withDepth()->having('depth', '=', 2)->get();
        return view('backend.product.elements.edit', compact('element', 'colors', 'choice_options', 'categories', 'tags', 'lang', 'element_attributes'));
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
//        $element->name = $request->name;
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
        if ($refund_request_addon != null && $refund_request_addon->activated == 1) {
            if ($request->refundable != null) {
                $element->refundable = 1;
            } else {
                $element->refundable = 0;
            }
        }
        $element->category_id = $request->category_id;
        $element->brand_id = $request->brand_id;
        $element->barcode = $request->barcode;
        $choice_options = $request->choice_options;
        $my_attributes = array();
        $my_characteristics = array();
        $my_choice_options = array();
        if ($choice_options) {
            foreach ($choice_options as $attribute => $values) {
                array_push($my_attributes, $attribute);
                if (is_array($values)) {
                    foreach ($values as $value) {
                        array_push($my_characteristics, $value);
                    }
                    array_push($my_choice_options, array($attribute => $values));
                }
            }
        }
        $element->choice_options = json_encode($my_choice_options ?? array());
        $element->attributes = json_encode($my_attributes ?? array());
        $element->characteristics = json_encode($my_characteristics ?? array());
        $element->colors = json_encode($request->colors ?? array());
//        if ($request->lang == env("DEFAULT_LANGUAGE", 'ru')) {
            $element->name = $request->name;
            $element->unit = $request->unit;
            $element->description = $request->description;
            if ($element->slug != $request->slug)
                $element->slug = SlugService::createSlug(Element::class, 'slug', slugify($request->name));
//        }
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
        if (Auth::user()->user_type == 'seller') {
            $element->user_id = Auth::user()->id;
        } else {
            $element->user_id = \App\User::where('user_type', 'admin')->first()->id;
        }

        $element->video_provider = $request->video_provider;
        $element->video_link = $request->video_link;
        $element->meta_title = $request->meta_title;
        $element->meta_description = $request->meta_description;
        $element->meta_img = $request->meta_img;
        if ($element->meta_title == null) {
            $element->meta_title = $element->name;
        }

        if ($element->meta_description == null) {
            $element->meta_description = $element->description;
        }
        $element->pdf = $request->pdf;
        $element->save();
        // Element Translations
        $element_translation = ElementTranslation::firstOrNew(['lang' => $request->lang, 'element_id' => $element->id]);
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
}
