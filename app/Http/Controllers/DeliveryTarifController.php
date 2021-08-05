<?php

namespace App\Http\Controllers;

use App\DeliveryTarif;
use Illuminate\Http\Request;

class DeliveryTarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_tarifs = DeliveryTarif::where('user_id', auth()->id())->orderBy('name', 'asc')->paginate(15);
        return view('backend.setup_configurations.delivery_tarifs.index', compact('delivery_tarifs'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $delivery = DeliveryTarif::firstOrNew([
            'user_id'=> auth()->id(),
            'name'=> $request->name,
            'distance_price'=>$request->distance_price,
            'days'=> $request->days,
            'weight_price'=>$request->weight_price,
            'express_percent'=>$request->express_percent,
            'express_hours'=>$request->express_hours,
            ]);
        $delivery->save();
        flash(translate('Delivery Tarif has been inserted successfully'))->success();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $delivery = DeliveryTarif::findOrFail($request->id);
        $delivery->user_id = auth()->id();
        $delivery->name = $request->name;
        $delivery->distance_price=$request->distance_price;
        $delivery->days= $request->days;
        $delivery->weight_price=$request->weight_price;
        $delivery->express_percent=$request->express_percent;
        $delivery->express_hours=$request->express_hours;
        $delivery->save();
        flash(translate('Delivery Tarif has been updated successfully'))->success();
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
        DeliveryTarif::destroy($id);
        flash(translate('Delivery Tarif has been deleted successfully'))->success();
        return $this->index();
    }
}
