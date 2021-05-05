<?php

namespace App\Http\Controllers;

use App\Branch;
use App\BranchTranslation;
use Illuminate\Http\Request;

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
        return view('backend.product.branches.index', compact('branches'));
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

        $branch_translation = BranchTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'branch_id' => $branch->id]);
        $branch_translation->name = $request->name;
        $branch_translation->save();

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
        if($request->lang == env("DEFAULT_LANGUAGE")){
          $branch->name = $request->name;
        }
        $branch->save();

        $branch_translation = BranchTranslation::firstOrNew(['lang' => $request->lang, 'branch_id' => $branch->id]);
        $branch_translation->name = $request->name;
        $branch_translation->save();

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
}