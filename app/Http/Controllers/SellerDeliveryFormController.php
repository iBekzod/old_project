<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Seller;
use App\Shop;
use App\User;

class SellerDeliveryFormController extends Controller
{
    public function seller_delivery_form_save(Request $request)
    {
        if ($request->method() === 'POST') {
            //  dd($request->all());
            $user_id = auth()->id();
            $user = User::findOrFail($user_id);
            $user->registration_step = 'active_3';
            $selection = json_decode($request->seller_document);
            $users = $selection->user_id;

            // dd($user);
            //    dd($selection);
            $date = $request->date;

            //  dd($data);
            // $time=time();
            // $date=date("d/m/Y",$time);
            if ($user->save()) {
                return view('frontend.user.seller.seller_delivery')->with('seller', $selection)->with('date', $date)->with('user_id', $users);
            }
        }
        else if ($request->method() === 'POST') {
            $user_id = auth()->id();
            // dd(auth());
              $user = User::findOrFail($user_id);
              dd($user);
        }
    }
    public function seller_page_form_save(Request $request)
    {
        if ($request->method() === 'POST') {
            $request->validate([
                'user_id' => 'required'
            ]);
            //  dd($request->all());
            $user_id = $request->user_id;
            $user = User::findOrFail($user_id);
            $user->registration_step = 'active_4';
            auth()->login($user, true);
            if ($user->save()) {
                return view('frontend.user.seller.dashboard');
            }
        }
        else if ($request->method() === 'POST') {

        }

    }
}
