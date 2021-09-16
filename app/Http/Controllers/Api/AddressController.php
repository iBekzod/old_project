<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddressCollection;
use App\Address;
use App\City;
use App\Http\Resources\V2\CitiesCollection;
use App\Http\Resources\V2\CountriesCollection;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        if($request->has('customer_note') ){
            $address->customer_note = $request->customer_note;
        }
        $address->save();

        return response()->json([
            'message' => 'Shipping information has been added successfully'
        ]);
    }

    public function updateShippingAddress(Request $request)
    {
        if($address=Address::where('id', $request->id)->first()){
            if($request->has('address') ){
                $address->address = $request->address;
            }
            if($request->has('user_id') ){
                $address->user_id = $request->user_id;
            }
            if($request->has('region_id') ){
                $address->region_id = $request->region_id;
            }
            if($request->has('city_id') ){
                $address->city_id = $request->city_id;
            }
            if($request->has('postal_code') ){
                $address->postal_code = $request->postal_code;
            }
            if($request->has('phone') ){
                $address->phone = $request->phone;
            }
            if($request->has('longitude') ){
                $address->longitude = $request->longitude;
            }
            if($request->has('latitude') ){
                $address->latitude = $request->latitude;
            }
            if($request->has('customer_note') ){
                $address->customer_note = $request->customer_note;
            }
            $address->save();
            return response()->json([
                'data'=>$address,
                'result' => true,
                'message' => 'Shipping information has been updated successfully'
            ]);
        }
        return response()->json([
            'data'=>[],
            'result' => false,
            'message' => 'Shipping information not found'
        ]);
    }

    public function updateShippingAddressLocation(Request $request)
    {
        $address = Address::find($request->id);
        $address->latitude = $request->latitude;
        $address->longitude = $request->longitude;
        $address->save();

        return response()->json([
            'data'=>$address,
            'result' => true,
            'message' => 'Shipping location in map updated successfully'
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


    public function makeShippingAddressDefault(Request $request)
    {
        Address::where('user_id', $request->user_id)->update(['set_default' => 0]); //make all user addressed non default first

        $address = Address::find($request->id);
        $address->set_default = 1;
        $address->save();
        return response()->json([
            'data'=>$address,
            'result' => true,
            'message' => 'Default shipping information has been updated'
        ]);
    }

    public function updateAddressInCart(Request $request)
    {
        try {
            Cart::where('user_id', $request->user_id)->update(['address_id' => $request->address_id]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Could not save the address'
            ]);
        }
        return response()->json([
            'result' => true,
            'message' => 'Address is saved'
        ]);


    }

    public function getCities()
    {
        return new CitiesCollection(City::all());
    }

    public function getCountries()
    {
        return new CountriesCollection(Country::where('status', 1)->get());
    }
}
