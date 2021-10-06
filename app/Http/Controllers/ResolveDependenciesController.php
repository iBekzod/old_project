<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NormalDependency;
use App\Services\SingleTonDependency;

class ResolveDependenciesController extends Controller
{
    private $normalDependency;
    private $manualDependency;

    public function __construct(NormalDependency $normalDependency)
    {
        $this->normalDependency = $normalDependency;
    }


    public function resolveDependencyManually()
    {
        // dd("hi");
        $this->manualDependency = resolve(SingleTonDependency::class);
        // dd($this->manualDependency);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return back();
    }
}
