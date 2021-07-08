<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\User;
use Auth;
use App\Seller;
use App\BusinessSetting;
use Cviebrock\EloquentSluggable\Services\SlugService;
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
            //   dd($request->all());
            $user_id = auth()->id();
            //  dd($user_id);
            $user = User::findOrFail($user_id);
            if (Seller::where('user_id', $user_id)->exists()) {
                $seller = Seller::where('user_id', $user_id)->first();
            } else {
                $seller = new Seller;
            }
            if (Shop::where('user_id', $user_id)->exists()) {
                $shop = Shop::where('user_id', $user_id)->first();
            } else {
                $shop = new Shop;
            }


            // dd($shop);
            //  dd($user);
            $user->registration_step = 'active_2';
            $array = array();
            $data = array();
            $i = 0;
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
                $item = array();
                if ($element->type) {
                    $item['type'] = $element->type;
                    $item['label'] = $element->label;
                    $item['value'] = $request[$element->label];
                    $array[$element->label] = $request[$element->label];
                }
                array_push($data, $item);
                $i++;
            }
            // dd($data);
            $seller->user_id = $user_id;
            $seller->verification_info = json_encode($data);
            //  dd($user_id);
            $shop->user_id =$user_id;
            $shop->name = $request->Название_магазина;
            $shop->address = $request->Адрес_регистрации_вендора;
            $shop->slug = SlugService::createSlug(Shop::class, 'slug', slugify($request->Название_магазина));
            // dd($shop);
            //   dd($seller->verification_info);
            $date = Carbon::parse($seller->created_at)->format('d-m-Y');
            // dd($array);
            // dd($date);
            if ($user->save()) {
                if ($seller->save()) {
                    if($shop->save()){
                        return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller', $seller)->with('date', $date);
                    }
                }
            }
        } else if ($request->method() === 'GET') {
            $user_id = auth()->id();
            $user = User::findOrFail($user_id);
            if (Seller::where('user_id', $user_id)->exists()) {
                $seller = Seller::where('user_id', $user_id)->first();
            }
            return view('frontend.user.seller.form_second')->with('user_id', $user_id);
        } else {
            return back();
        }
    }
    public function Seller_autoidentification_form_update(Request $request)
    {
        // dd($request->all());

        if ($request->method() === 'POST') {
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as  $element) {
                if ($element->type) {

                   $validation[$element->label] = 'required';
                    // dd('keldi');

                }
            }
              $request->validate($validation);
            //    dd( $request->validate($validation));
            $user_id = auth()->id();
            // dd($user_id);
            if (Seller::where('user_id', $user_id)->exists()) {
                $seller = Seller::where('user_id', $user_id)->first();
            }
            // $seller=Seller::findOrFail($user_id);
            //   dd($seller);
            $data = array();
            $i = 0;
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
                $item = array();
                if ($element->type) {
                    $item['type'] = $element->type;
                    $item['label'] = $element->label;
                    $item['value'] = $request[$element->label];
                    $array[$element->label] = $request[$element->label];
                }
                // dd($item);
                array_push($data, $item);
                $i++;
            }
            $seller->verification_info = json_encode($data);
            // dd($seller->verification_info[0]);
            if ($seller->save()) {
                flash(translate('Your autoidentification form update has been updated successfully!'))->success();
                return back();
            }
        }


    }
}
