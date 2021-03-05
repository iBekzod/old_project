<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCharacteristics;
use App\Models\ProductAttributeCharacteristicTranslation;
use App\Models\ProductAttributeTranslation;
use App\Product;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = ProductAttribute::latest()->get();
        $categories = Category::all()->toTree();

        return view('backend.product-attributes.index', compact('attributes','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id'=>'required'
        ]);

        $attribute = ProductAttribute::create([
            'name' => $request->get('name')
        ]);

        $attribute->categories()->attach($request->get('category_id'));

        $attribute_translation = ProductAttributeTranslation::firstOrNew([
            'lang' => env('DEFAULT_LANGUAGE'),
            'attribute_id' => $attribute->id
        ]);
        $attribute_translation->name = $request->get('name');
        $attribute_translation->save();

        flash(translate('Attribute has been inserted successfully'))->success();
        return redirect()->route('product-attributes.index');
    }

    public function changeCategories(Request $request, $id)
    {
        $attr = ProductAttribute::findOrFail($id);
        $attr->categories()->detach();
        $attr->categories()->attach($request->get('category_id'));

        return back();
    }

    public function createAttr(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'attribute_id' => 'required'
        ]);

        $attribute = ProductAttributeCharacteristics::create([
            'name' => $request->get('name'),
            'attribute_id' => (int)$request->get('attribute_id')
        ]);

        $attribute_translation = ProductAttributeCharacteristicTranslation::firstOrNew([
            'lang' => env('DEFAULT_LANGUAGE'),
            'attribute_id' => $attribute->id
        ]);

        $attribute_translation->name = $request->get('name');
        $attribute_translation->save();

        flash(translate('Attribute has been inserted successfully'))->success();
        return redirect()->route('product-attributes.edit', [$request->get('attribute_id'), 'lang' => $request->get('lang')]);
    }

    public function editAttr(Request $request, $id)
    {
        if ($request->method() == 'POST') {

            $attribute = ProductAttributeCharacteristics::findOrFail($id);
            $attribute->values()->delete();

            foreach ($request->get('attr_values') as $item)
            {
                AttributeValue::create([
                    'attribute_id'  => $id,
                    'value'         => $item
                ]);
            }

            flash(translate('Attribute values has been saved successfully'))->success();
            return back();
        } else {
            $lang = $request->lang;
            $attribute = ProductAttributeCharacteristics::findOrFail($id);

            return view('backend.product-attributes.edit_attr', compact('attribute', 'lang'));
        }
    }

    public function updateAttr(Request $request, $id)
    {
        $attribute = ProductAttributeCharacteristics::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $attribute->name = $request->name;
        }
        $attribute->save();

        $attribute_translation = ProductAttributeCharacteristicTranslation::firstOrNew(['lang' => $request->lang, 'attribute_id' => $attribute->id]);
        $attribute_translation->name = $request->name;
        $attribute_translation->save();

        flash(translate('Attribute has been updated successfully'))->success();
        return back();
    }

    public function destroyAttr($id)
    {
        $attribute = ProductAttributeCharacteristics::findOrFail($id);
        $parent_id = $attribute->attribute_id;

        foreach ($attribute->attribute_translations as $key => $attribute_translation) {
            $attribute_translation->delete();
        }

        ProductAttributeCharacteristics::destroy($id);
        flash(translate('Attribute has been deleted successfully'))->success();
        return redirect()->back();
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
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $attr = ProductAttribute::where('id', $id)->with('categories')->firstOrFail();
        $attributes = $attr->attributes;
        $selected_categories = $attr->categories;
        $selected_categories = $selected_categories->pluck('id');
        $selected_categories = $selected_categories->toArray();
        $categories = Category::all()->toTree();

        return view('backend.product-attributes.edit', compact('attr', 'attributes', 'lang', 'categories', 'selected_categories'));
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
        $attribute = ProductAttribute::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $attribute->name = $request->name;
        }
        $attribute->save();

        $attribute_translation = ProductAttributeTranslation::firstOrNew(['lang' => $request->lang, 'attribute_id' => $attribute->id]);
        $attribute_translation->name = $request->name;
        $attribute_translation->save();

        flash(translate('Attribute has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $attribute = ProductAttribute::findOrFail($id);

        foreach ($attribute->attribute_translations as $key => $attribute_translation) {
            $attribute_translation->delete();
        }

        ProductAttribute::destroy($id);
        flash(translate('Attribute has been deleted successfully'))->success();
        return redirect()->route('product-attributes.index');
    }
}
