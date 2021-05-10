<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Attribute;
use App\Characteristic;
use App\AttributeTranslation;
use App\Language;
class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // CoreComponentRepository::instantiateShopRepository();
        $attributes = Attribute::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.product.attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute = new Attribute;
        $attribute->name = $request->name;
        $attribute->save();


        foreach (Language::all() as $language){
            //  Attribute  Translation
            $attribute_translation = AttributeTranslation::firstOrNew(['lang' => $language->code, 'attribute_id' => $attribute->id]);
            $attribute_translation->name = $attribute->name;
            $attribute_translation->save();
        }

        flash(translate('Attribute has been inserted successfully'))->success();
        return back();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang      = $request->lang;
        $attribute = Attribute::findOrFail($id);
        return view('backend.product.attribute.edit', compact('attribute','lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->save();
        if(AttributeTranslation::where('attribute_id' , $attribute->id)->where('lang' , default_language())->first()){
            foreach (Language::all() as $language) {
                $attribute_translation = AttributeTranslation::firstOrNew(['lang' => $language->code, 'attribute_id' => $attribute->id]);
                $attribute_translation->name = $request->name;
                $attribute_translation->save();
            }
        }

        flash(translate('Attribute has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        foreach ($attribute->attribute_translations as $key => $attribute_translation) {
            $attribute_translation->delete();
        }

        Attribute::destroy($id);
        flash(translate('Attribute has been deleted successfully'))->success();
        return redirect()->route('backend.product.attributes.index');
    }

    public function editCategories($id){
        $attribute = Attribute::findOrFail($id);
        $categories = Category::withDepth()->having('depth', '=', 2)->get();
        return view('backend.product.attribute.edit_categories', compact('attribute','categories'));
    }

    public function updateCategories(Request $request, $id){
        $attribute = Attribute::findOrFail($id);
        $attribute->categories()->detach();
        $attribute->categories()->attach($request->get('category_id'));
        return back();
    }

    public function editCharacteristics($id){
        $attribute = Attribute::findOrFail($id);
        $characteristics = Characteristic::orderBy('created_at', 'desc')->get();
        return view('backend.product.attribute.edit_characteristics', compact('attribute','characteristics'));
    }

    public function updateCharacteristics(Request $request, $id){
        $attribute = Attribute::findOrFail($id);
        $attribute->characteristics()->detach();
        $attribute->characteristics()->attach($request->get('characteristic_id'));
        return back();
    }
}
