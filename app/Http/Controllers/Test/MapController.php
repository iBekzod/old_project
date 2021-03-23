<?php

namespace App\Http\Controllers\Test;

use App\Http\Resources\AddressCollection;
use App\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MapController extends Controller
{
    public function index(){
        $addresses=Auth::user()->addresses;
        return view('test.map', compact('addresses'));
    }
    public function addresses($id)
    {
        return new AddressCollection(Address::where('user_id', $id)->get());
    }

    public function createShippingAddress(Request $request)
    {
        $address = new Address;
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->longitude = $request->longitude;
        $address->latitude = $request->latitude;
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
