<?php

namespace App\Http\Controllers;

use App\Country;
use App\ReportDescription;
use Illuminate\Http\Request;
// use App\FoundItCheaper;

class ReportDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "came";
        $report_description=ReportDescription::latest()->paginate(15);
        //  dd($report_description);
        // return view('backend.marketing.subscribers.index', compact('subscribers'));
         return view('backend.support.report_description.report_description')->with('report_description',$report_description);
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
        // $subscriber = Subscriber::where('email', $request->email)->first();
        // if($subscriber == null){
        //     $subscriber = new Subscriber;
        //     $subscriber->email = $request->email;
        //     $subscriber->save();
        //     flash(translate('You have subscribed successfully'))->success();
        // }
        // else{
        //     flash(translate('You are  already a subscriber'))->success();
        // }
        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $report_description=ReportDescription::findOrFail(decrypt($id));
        //   dd($report_description);
        if($report_description){
                return view('backend.support.report_description.show', compact('report_description'));
        }
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
        if($report_description = ReportDescription::findOrFail(decrypt($id))){
            if($report_description){
                $report_description->delete();
            }
            flash(translate('FoundItCheaper has been deleted successfully'))->success();
                return back();
        }
    }
}
