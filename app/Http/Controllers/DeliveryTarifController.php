<?php

namespace App\Http\Controllers;

use App\City;
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
        $delivery_tarifs = DeliveryTarif::orderBy('distance', 'asc')->paginate(15);
        $regions=City::where('type', 'region')->get();
        return view('backend.setup_configurations.delivery_tarifs.index', compact('delivery_tarifs', 'regions'));
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
            'seller_region_id'=>$request->seller_region_id,
            'client_region_id'=>$request->client_region_id,
            'distance'=>$request->distance
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
        $delivery->seller_region_id = $request->seller_region_id;
        $delivery->client_region_id = $request->client_region_id;
        $delivery->distance=$request->distance;
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
