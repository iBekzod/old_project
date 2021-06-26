<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Seller;
use App\Shop;
use App\User;
use App\BusinessSetting;
use PhpParser\Node\Stmt\If_;

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
             $date=$selection->created_at;

            // dd($user);
            //    dd($selection);


            if ($user->save()) {
                // return 'ketti';
                return view('frontend.user.seller.seller_delivery')->with('seller', $selection)->with('user_id', $user_id)->with('date', $date);
            }
        }
        else if ($request->method() === 'GET') {
            $user_id = auth()->id();
            $user = User::findOrFail($user_id);
            $array=array();
            if(Seller::where('user_id', $user_id)->exists()){
                $seller=Seller::where('user_id', $user_id)->first();
                //   dd($seller->verification_info);
                    //  dd($seller);

                // dd(json_decode($seller->verification_info));
                foreach (($seller->verification_info) as  $element) {
                    $array[$element['label']]=$element['value'];
                }

                return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller',$seller);

             }
            //  else{
            //     return redirect()->route('seller.autoidentification');
            // }
        };
    }
    public function seller_page_form_save(Request $request)
    {
        if ($request->method() === 'POST') {

            $user_id = auth()->id();
            $user = User::findOrFail($user_id);
            $user->registration_step = 'active_4';
            if ($user->save()) {
                return view('frontend.user.seller.dashboard');
            }
        }  else if ($request->method() === 'GET') {
            $user_id = auth()->id();
                 return redirect()->route('seller.autoidentification'); ;

        }
    }
}
