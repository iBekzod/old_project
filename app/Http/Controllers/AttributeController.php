<?php

namespace App\Http\Controllers;

use App\Category;
use App\Element;
use Illuminate\Http\Request;
use App\Attribute;
use App\Characteristic;
use App\AttributeTranslation;
use App\Branch;
use App\CharacteristicTranslation;
use CoreComponentRepository;
use App\Language;
class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // CoreComponentRepository::instantiateShopRepository();
        $attributes = Attribute::orderBy('created_at', 'desc');
        $branches = Branch::all();
        $sort_search = null;
        if ($request->has('search') && $request->search != null) {
            $attributes = $attributes->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $attributes = $attributes->paginate(15);
        return view('backend.product.attribute.index', compact('attributes', 'sort_search', 'branches'));
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
        $attribute->combination = false;
        if($request->has('branch_id')) $attribute->branch_id = $request->branch_id;
        if($request->has('selected_branch_id')) $attribute->branch_id = $request->selected_branch_id;
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
        $attribute = Attribute::where('id',$id)->first();
        $attribute->name=$request->name;
        // $attribute = Attribute::withTrashed()->firstOrNew([
        //     'id'=>$id,
        //     'name'=>$request->name
        // ]);
        // if($attribute->name == $request->name){
        //     flash(translate('Attribute has same name'))->success();
        //     return back();
        // }
        $attribute->combination = false;
        if($request->has('branch_id')) $attribute->branch_id = $request->branch_id;
        if($request->has('edit_branch_attribute_'.$attribute->id)) $attribute->branch_id = $request->input('edit_branch_attribute_'.$attribute->id);
        $attribute->save();
        foreach (Language::all() as $language) {
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

        $attribute->delete();
        flash(translate('Attribute has been deleted successfully'))->success();
        return back();
    }

//    public function editCategories($id){
//        $attribute = Attribute::findOrFail($id);
//        $categories = Category::withDepth()->having('depth', '=', 2)->get();
//        return view('backend.product.attribute.edit_categories', compact('attribute','categories'));
//    }

//    public function updateCategories(Request $request, $id){
//        $attribute = Attribute::findOrFail($id);
//        $attribute->categories()->detach();
//        $attribute->categories()->attach($request->get('category_id'));
//        return back();
//    }

//    public function editCharacteristics($id){
//        $attribute = Attribute::findOrFail($id);
//        $characteristics = Characteristic::orderBy('created_at', 'desc')->get();
//        return view('backend.product.attribute.edit_characteristics', compact('attribute','characteristics'));
//    }

    public function updateCharacteristics(Request $request){
//        dd($request);
        $attribute = Attribute::findOrFail($request->id);
        $attribute->characteristics()->delete();
        $values=$request->get('characteristics');
        if($values){
            foreach ($values as $value){
                $characteristic=Characteristic::withTrashed()->firstOrNew([
                    'name'=>$value,
                    'attribute_id'=>$attribute->id
                ]);
                if ($characteristic->trashed()) $characteristic->restore();
                if($characteristic->save()){
                    foreach (Language::all() as $language) {
                        $characteristic_translation = CharacteristicTranslation::firstOrNew(['lang' => $language->code, 'characteristic_id' => $characteristic->id]);
                        $characteristic_translation->name = $value;
                        $characteristic_translation->save();
                    }
                }

            }
        }

        return back();
    }

    public function editCharacteristics(Request $request)
    {
        try {
            if ($request->method() == 'GET'){
                $data=null;
                if ($request->has('attribute_id')){
                    $attribute_id=$request->attribute_id;
                    $attribute = Attribute::findOrFail($attribute_id);
                    $options = null;
                    foreach ($attribute->characteristics as $value) {
                        $options = $options . '<option selected value = "' . $value->name . '" > ' . $value->getTranslation('name') . ' </option >';
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

    public function update_combination_status(Request $request)
    {
        $attribute = Attribute::findOrFail($request->id);
        $attribute->combination = $request->status;
        if ($attribute->save()) {
            return 1;
        }
        return 0;
    }
}
