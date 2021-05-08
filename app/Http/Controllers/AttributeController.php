<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attribute;
use App\AttributeTranslation;
use CoreComponentRepository;
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
        $attributes = Attribute::orderBy('created_at', 'desc')->get();
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

        $attribute_translation = AttributeTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'attribute_id' => $attribute->id]);
        $attribute_translation->name = $request->name;
        $attribute_translation->save();

        foreach (Language::all() as $language){
            //  Attribute  Translation
            $attribute_translation = c::firstOrNew(['lang' => $language->code, 'product_id' => $attribute->id]);
            $attribute_translation->name = $attribute->name;
            $attribute_translation->save();
        }

        flash(translate('Attribute has been inserted successfully'))->success();
        return redirect()->route('attributes.index');


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
        if($request->lang == default_language()){
          $attribute->name = $request->name;
        }
        $attribute->save();

        $attribute_translation = AttributeTranslation::firstOrNew(['lang' => $request->lang, 'attribute_id' => $attribute->id]);
        $attribute_translation->name = $request->name;
        $attribute_translation->save();

        if(AttributeTranslation::where('attribute_id' , $attribute->id)->where('lang' , $request->lang)->first()){
            foreach (Language::all() as $language){
                $attribute_translation = AttributeTranslation::firstOrNew(['lang' => $language->code, 'attribute_id' => $attribute->id]);
                $attribute_translation->name = $request->name;
                $attribute_translation->save();
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
        return redirect()->route('attributes.index');
    }


    public function updateCategories(Request $request, $id){
        $attribute = Attribute::findOrFail($id);
        $attribute->categories()->detach();
        $attribute->categories()->attach($request->get('category_id'));
        return back();
    }
    public function updateCharacteristics(Request $request, $id){
        $attribute = Attribute::findOrFail($id);
        $attribute->characteristics()->detach();
        $attribute->characteristics()->attach($request->get('characteristic_id'));
        return back();
    }
}
