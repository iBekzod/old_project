<?php

namespace App\Http\Controllers;

use App\Address;
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
        //   dd($request->all());
        if ($request->method() === 'POST') {
            $validation = array();
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
                if ($element->type) {
                    $validation[$element->label] = 'required';
                }
            }
            //   dd($validation);
            // $request->validate($validation);
            // dd($validation);

            $request->validate([
             'country_id'=>'required',
             'region_id' =>'required',
             'city_id' =>'required',
             'latitude'=>'required',
             'longitude'=>'required'
            ]);


            // dd($request->all());






            // 'user_id', 'address', 'city_id', 'region_id', 'postal_code', 'phone', 'set_default', 'longitude', 'latitude'

//             array:22 [▼
//   "_token" => "AIPJfsXF4Rj6pD1ALvxVst1VYLsCtu5sbs1Eaurx"
//   "Форма_собственности" => "ООО"
//   "Юридическое_название_вендора" => "Porro officia ipsa"
//   "Название_магазина" => "Cillum aliqua Omnis"
//   "Адрес_регистрации_вендора" => "Minim illum tenetur"
//   "Физический_адрес_вендора" => "Rem elit pariatur"
//   "ИНН" => "52"
//   "Название_банка" => "Velit suscipit culpa"
//   "МФО_банка" => "78"
//   "РС" => "42"
//   "ФИО_директора" => "Corrupti et omnis n"
//   "Тел_директора" => "26"
//   "Электронная_почта_директора" => "zizepypy@mailinator.com"
//   "ФИО_менеджера_ответственного_за_сотрудничество" => "Tenetur placeat nul"
//   "Тел_менеджера" => "98"
//   "Электронная_почта_менеджера" => "jona@mailinator.com"
//   "Почтовый_индекс" => "92"
//   "country_id" => "234"
//   "region_id" => "47"
//   "city_id" => "152"
//   "latitude" => "40.8005366"
//   "longitude" => "72.15938419999999"
// ]

                //   dd($validation);
            $user_id = auth()->id();
            //  dd($user_id);
            $user = User::findOrFail($user_id);
            // dd($user);
            if(Address::where('user_id', $user_id)->exists()){
                $address_full=Address::where('user_id', $user_id)->first();
            }
            else{
                $address_full=new Address;
            }
            // $address_full= new Address;
            // dd($address_full);
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

            // dd($address_full);
            // dd($shop);
            // dd($user);
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
            $shop->name = $request->name_of_shop;
            $shop->address = $request->vendor_registration_address;
            $shop->slug = SlugService::createSlug(Shop::class, 'slug', slugify($request->name_of_shop));

            $address_full->user_id=$user_id;
            $address_full->address=$request->Physical_address_vendora;
            // dd($address_full->address);
            $address_full->city_id=$request->city_id;
            // dd($address_full->city_id);
            $address_full->region_id=$request->region_id;
            // dd($address_full->region_id);

            $address_full->postal_code=$request->postal_code;
            // dd($address_full->postal_code);
            $address_full->phone=$request->Director_phone_number;
            // dd($address_full->phone);
            $address_full->set_default=0;
            // dd($address_full->set_default);
            $address_full->longitude=$request->region_id;
            $address_full->latitude=$request->region_id;

            dd($address_full->all());
            // dd($shop);
            //   dd($seller->verification_info);
            $date = Carbon::parse($seller->created_at)->format('d-m-Y');
            // dd($array);
            // dd($date);
            if ($user->save()) {
                if ($seller->save()) {
                    if($shop->save()){
                        if($address_full->save()){
                            return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller', $seller)->with('date', $date);
                        }
                    }
                }
            }
        } else if ($request->method() === 'GET')
        {
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