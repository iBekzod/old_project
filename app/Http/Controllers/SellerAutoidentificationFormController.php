<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Shop;
use App\User;
use Auth;
use App\Seller;
use App\BusinessSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Carbon;

class SellerAutoidentificationFormController extends Controller
{
   public function seller_autoidentification_form_save(Request $request)
   {
        if ($request->method() === 'POST') {
             $validation = array();
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
                if ($element->type) {
                    $validation[$element->label] = 'required';
                }
            }


             $request->validate($validation);
            //    dd($array);
            $user_id = auth()->id();
            //  dd($user_id);
            $user = User::findOrFail($user_id);
            if(Seller::where('user_id', $user_id)->exists()){
                $seller=Seller::where('user_id', $user_id)->first();
            }else{
                $seller=new Seller;
            }
            //  dd($user);
            $user->registration_step='active_2';
            $array=array();
            $data = array();
            $i = 0;
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
                $item = array();
                if ($element->type) {
                    $item['type'] = $element->type;
                    $item['label'] = $element->label;
                    $item['value'] = $request[$element->label];
                    $array[$element->label]=$request[$element->label];
                }
                array_push($data, $item);
                $i++;
            }
            $seller->user_id=$user_id;
            $seller->verification_info = json_encode($data);
            $date=Carbon::parse($seller->created_at)->format('d-m-Y');
            // dd($date);
            if($user->save()){
                if($seller->save()){
                    return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller',$seller)->with('date',$date);
                }
            }
        }
        else if($request->method() === 'GET'){
             $user_id = auth()->id();
             $user = User::findOrFail($user_id);
             if(Seller::where('user_id', $user_id)->exists()){
                 $seller=Seller::where('user_id', $user_id)->first();
             }
            return view('frontend.user.seller.form_second')->with('user_id',$user_id);
        }
        else{
            return back();
        }




   }


}
