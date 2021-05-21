<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Branch;
use App\BranchTranslation;
use App\Category;
use Illuminate\Http\Request;
use App\Language;
use App\Characteristic;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderBy('created_at', 'desc')->get();
        $attribute_selections = Attribute::orderBy('name', 'desc')->get();
        return view('backend.product.branches.index', compact('branches', 'attribute_selections'));
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
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->save();

        foreach (Language::all() as $language){
            // Branch  Translation
            $branch_translation = BranchTranslation::firstOrNew(['lang' => $language->code, 'branch_id' => $branch->id]);
            $branch_translation->name = $branch->name;
            $branch_translation->save();
        }

        flash(translate('Branch has been inserted successfully'))->success();
        return redirect()->route('branches.index');
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
        $branch = Branch::findOrFail($id);
        return view('backend.product.branches.edit', compact('branch','lang'));
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
        $branch = Branch::findOrFail($id);
        $branch->name = $request->name;
        $branch->save();

        if(BranchTranslation::where('branch_id' , $branch->id)->where('lang' , default_language())->first()){
            foreach (Language::all() as $language){
                $branch_translation = BranchTranslation::firstOrNew(['lang' => $language->code, 'branch_id' => $branch->id]);
                $branch_translation->name = $request->name;
                $branch_translation->save();
            }
        }

        flash(translate('Branch has been updated successfully'))->success();
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
        $branch = Branch::findOrFail($id);

        foreach ($branch->branch_translations as $key => $branch_translation) {
            $branch_translation->delete();
        }

        Branch::destroy($id);
        flash(translate('branch has been deleted successfully'))->success();
        return redirect()->route('branches.index');
    }

    public function arribute_index(Request $request){
        if($request->has('id')){
            $branch = Branch::findOrFail($request->id);
            $branches = Branch::all();
            if($attributes=$branch->attributes()->paginate(15)){
                return view('backend.product.attribute.index', compact('attributes', 'branch', 'branches'));
            }
        }else{
            $branch = null;
            $branches = Branch::all();
            if($attributes=Attribute::where('branch_id', '=', null)->paginate(15)){
                return view('backend.product.attribute.index', compact('attributes', 'branch', 'branches'));
            }
        }
        flash(translate('Branch has no attributes'))->message();
        return redirect()->route('branches.index');
    }

//    public function updateAttributes(Request $request, $id)
//    {
//        $branch = Branch::findOrFail($id);
//
//        $branch->attributes->detach();
//        $branch->attributes->attach($request->get('attribute_id'));
//        return back();
//    }
}
