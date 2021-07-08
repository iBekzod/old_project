<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Seller;
use App\Shop;
use App\User;
use App\BusinessSetting;
use PhpParser\Node\Stmt\If_;
use Carbon\Carbon;

class SellerDeliveryFormController extends Controller
{
    public function seller_delivery_form_save(Request $request)
    {
        if ($request->method() === 'POST') {
            //  dd($request->all());
            $user_id = auth()->id();
            $user = User::findOrFail($user_id);
            $selection=array();
            if(Seller::where('user_id', $user_id)->exists()){
                $seller=Seller::where('user_id', $user_id)->first();

                foreach (($seller->verification_info) as  $element) {
                    $selection[$element['label']]=$element['value'];
                }
            }
            // dd($selection);
            $user->registration_step = 'active_3';
            // $seller=Seller::findOrFail($user_id);
            $date=Carbon::parse($seller->created_at)->format('d-m-Y');
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
                $date=Carbon::parse($seller->created_at)->format('d-m-Y');
                //  dd($date);

                return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller',$seller)->with('date',$date);

             }
             else{
                return back();
            }
        }
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
                 $user = User::findOrFail($user_id);
                  $selection=array();
                 if(Seller::where('user_id', $user_id)->exists()){
                     $seller=Seller::where('user_id', $user_id)->first();
                     foreach (($seller->verification_info) as  $element) {
                         $selection[$element['label']]=$element['value'];
                     }
                    // dd($selection);
                    //   dd($selection);
                    $date=Carbon::parse($seller->created_at)->format('d-m-Y');
                    // dd($date);
                     return view('frontend.user.seller.seller_delivery')->with('seller', $selection)->with('user_id', $user_id)->with('date',$date);

                  }

        }
    }
}
