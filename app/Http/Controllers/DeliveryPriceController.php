<?php

namespace App\Http\Controllers;

use App\DeliveryPrice;
use Illuminate\Http\Request;

class DeliveryPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = DeliveryPrice::where('user_id', auth()->id())->orderBy('distance', 'asc')->paginate(15);
        return view('backend.setup_configurations.delivery_prices.index', compact('deliveries'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $delivery = DeliveryPrice::firstOrNew([
                'user_id'=> auth()->id(),
                'distance'=> $request->distance,
                'distance_price'=>$request->distance_price
            ]);
            $delivery->days= $request->days;
            $delivery->weight_price=$request->weight_price;
            $delivery->express_percent=$request->express_percent;
            $delivery->express_hours=$request->express_hours;
            $delivery->save();
            flash(translate('Delivery Price has been inserted successfully'))->success();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return $this->index();
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
        $delivery = DeliveryPrice::findOrFail($request->id);
        $delivery->user_id = auth()->id();
        $delivery->distance = $request->distance;
        $delivery->distance_price=$request->distance_price;
        $delivery->days= $request->days;
        $delivery->weight_price=$request->weight_price;
        $delivery->express_percent=$request->express_percent;
        $delivery->express_hours=$request->express_hours;
        $delivery->save();
        flash(translate('Delivery Price has been updated successfully'))->success();
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
        DeliveryPrice::destroy($id);
        flash(translate('Delivery Price has been deleted successfully'))->success();
        return $this->index();
    }
}
