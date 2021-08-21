<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddressCollection;
use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function addresses($id)
    {
        return new AddressCollection(Address::where('user_id', $id)->get());
    }

    public function createShippingAddress(Request $request)
    {
        if($request->has('city_id')){
            $address = Address::firstOrNew(['user_id' => $request->user_id, 'city_id' => $request->city_id]);
        }else if($request->has('address')){
            $address = Address::firstOrNew(['user_id' => $request->user_id, 'address' => $request->address]);
        }else if($request->has('longitude')){
            $address = Address::firstOrNew(['user_id' => $request->user_id, 'longitude' => $request->longitude]);
        }else{
            $address = new Address;
        }



        $address->address = $request->address??'';
        $address->region_id = $request->region_id??0;
        $address->city_id = $request->city_id??0;
        $address->postal_code = $request->postal_code??0;
        $address->phone = $request->phone??auth()->user()->phone;
        $address->longitude = $request->longitude??0;
        $address->latitude = $request->latitude??0;
        $address->save();

        return response()->json([
            'message' => 'Shipping information has been added successfully'
        ]);
    }

    public function deleteShippingAddress($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        return response()->json([
            'message' => 'Shipping information has been added deleted'
        ]);
    }
}
