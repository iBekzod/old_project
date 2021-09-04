<?php

namespace App\Http\Controllers;

use App\SupportService;
use Illuminate\Http\Request;
// use App\FoundItCheaper;

class SupportServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "came";
        $support_service=SupportService::latest()->paginate(15);
        // dd($support_service);
         return view('backend.support.support_service.support_service')->with('support_service',$support_service);
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
        $support_service=SupportService::findOrFail(decrypt($id));
        //  dd($found_it_cheaper);
        $support_service->viewed=1;
        if($support_service->save()){
                return view('backend.support.support_service.show', compact('support_service'));
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
        if($support_service = SupportService::findOrFail(decrypt($id))){
            if($support_service){
                $support_service->delete();
            }
            flash(translate('FoundItCheaper has been deleted successfully'))->success();
                return back();
        }
    }
}
