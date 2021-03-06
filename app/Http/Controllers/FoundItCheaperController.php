<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\FoundItCheaper;

class FoundItCheaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $found_it_cheaper=FoundItCheaper::latest()->paginate(15);
        // dd($found_it_cheaper);
        // return view('backend.marketing.subscribers.index', compact('subscribers'));
         return view('backend.support.found_it_cheapers.cheaper')->with('found_it_cheapers',$found_it_cheaper);
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
        $subscriber = Subscriber::where('email', $request->email)->first();
        if($subscriber == null){
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->save();
            flash(translate('You have subscribed successfully'))->success();
        }
        else{
            flash(translate('You are  already a subscriber'))->success();
        }
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
        // dd($id);
        $found_it_cheaper=FoundItCheaper::findOrFail(decrypt($id));
        //  dd($found_it_cheaper);
        $found_it_cheaper->viewed=1;
        if($found_it_cheaper->save()){
                return view('backend.support.found_it_cheapers.show', compact('found_it_cheaper'));
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
        if($found_it_cheaper = FoundItCheaper::findOrFail(decrypt($id))){
            if($found_it_cheaper){
                $found_it_cheaper->delete();
            }
            flash(translate('FoundItCheaper has been deleted successfully'))->success();
                return back();
        }
    }
}
