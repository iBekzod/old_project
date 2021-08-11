<?php

namespace App\Http\Controllers;

use App\City;
use App\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::orderBy('distance', 'asc')->paginate(15);
        $regions=City::where('type', 'region')->get();
        return view('backend.setup_configurations.deliveries.index', compact('deliveries', 'regions'));
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
            'seller_region_id'=>$request->seller_region_id,
            'client_region_id'=>$request->client_region_id
        ]);
        $delivery->distance = $request->distance;
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
        $delivery = Delivery::findOrFail($request->id);
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
        Delivery::destroy($id);
        flash(translate('Delivery Tarif has been deleted successfully'))->success();
        return $this->index();
    }
}
