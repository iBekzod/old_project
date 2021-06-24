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
            $user = new User;
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
            
        }
    }
    public function seller_page_form_save(Request $request)
    {
        if ($request->method() === 'POST') {
            $request->validate([
                'user_id' => 'required'
            ]);
            //  dd($request->all());
            $user = new User;
            $user->registration_step = 'active_4';
            // dd($user->registration_step);
            $user_id = $request->user_id;
            $user = User::findOrFail($user_id);
            //     if( $seller = Seller::findOrFail($user)==false){
            //   return 'error';
            //     }
            // $seller = Seller::findOrFail(decrypt($user));
            // $users = $seller->user;
            // dd($users);
            auth()->login($user, true);
            if ($user->save()) {
                return view('frontend.user.seller.dashboard');
            }
        }
        else if ($request->method() === 'POST') {

        }

    }
}
