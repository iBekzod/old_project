<?php

namespace App\Http\Controllers;

use App\Delivery;
use Illuminate\Http\Request;

class SellerDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::where('user_id', auth()->id())->orderBy('distance', 'asc')->paginate(15);
        return view('frontend.deliveries.index', compact('deliveries'));
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
        $delivery = Delivery::firstOrNew([
            'user_id'=>$request->user_id = auth()->id(),
            'distance'=>$request->distance = $request->distance,
            'price'=>$request->price = $request->price,
            'days'=>$request->days = $request->days,
            ]);
        $delivery->save();
        flash(translate('Delivery has been inserted successfully'))->success();
        return redirect()->back();
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
    public function edit($id)
    {
         $delivery  = Delivery::findOrFail($id);
         return view('frontend.deliveries.edit', compact('delivery'));
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
        $delivery = Delivery::firstOrNew([
            'user_id'=>$request->user_id = auth()->id(),
            'distance'=>$request->distance = $request->distance,
            'price'=>$request->price = $request->price,
            ]);
        $delivery = Delivery::findOrFail($id);
        $delivery->user_id = auth()->id();
        $delivery->distance = $request->distance;
        $delivery->price = $request->price;
        $delivery->days = $request->days;
        $delivery->save();
        flash(translate('Delivery has been updated successfully'))->success();
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Delivery::destroy($id);
        flash(translate('Delivery has been deleted successfully'))->success();
        return $this->index();
    }
}
