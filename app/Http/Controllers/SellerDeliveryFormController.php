<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Seller;
use App\Shop;
use App\User;
use App\BusinessSetting;

use Barryvdh\DomPDF\Facade as PDF;

use App\SellerSetting;

use PhpParser\Node\Stmt\If_;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;

class SellerDeliveryFormController extends Controller
{
    public function seller_delivery_form_save(Request $request)
    {
        if ($request->method() === 'POST') {
            //  dd($request->all());
            // $user_id = auth()->id();
            // $user = User::findOrFail($user_id);
            // $selection=array();
            // if(Seller::where('user_id', $user_id)->exists()){
            //     $seller=Seller::where('user_id', $user_id)->first();

            //     foreach (($seller->verification_info) as  $element) {
            //         $selection[$element['label']]=$element['value'];
            //     }
            // }
            // // dd($selection);
            // $user->registration_step = 'active_3';
            // // $seller=Seller::findOrFail($user_id);
            // $date=Carbon::parse($seller->created_at)->format('d-m-Y');
            // if ($user->save()) {
            //     // return 'ketti';
            //     return view('frontend.user.seller.seller_delivery')->with('seller', $selection)->with('user_id', $user_id)->with('date', $date);
            // }

             $user_id = auth()->id();
            $user = User::findOrFail($user_id);
            $user->registration_step = 'active_3';



            $admin=User::where('user_type', 'admin')->first();
            $settings = SellerSetting::where('user_id',  $admin->id);
            foreach($settings as $setting){
                $new_setting = $setting->replicate();
                $new_setting->user_id = $user_id;
                $new_setting->save();
            }
            if ($user->save()) {
                  $shop = Auth::user()->shop;
                  return view('frontend.user.seller.shop', compact('shop'));
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



            $admin=User::where('user_type', 'admin')->first();
            $settings = SellerSetting::where('user_id',  $admin->id);
            foreach($settings as $setting){
                $new_setting = $setting->replicate();
                $new_setting->user_id = $user_id;
                $new_setting->save();
            }

            if ($user->save()) {
                return view('frontend.user.seller.dashboard');
            }
        }
        else if ($request->method() === 'GET')
        {


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
    //  public function generatorPDF()
    // {
    // //   return 'came';

    //   // retreive all records from db
    //   $data =Seller::all();

    //   // share data to view
    //   view()->share('employee',$data);
    //   $pdf = PDF::loadView('pdf_view', $data);

    //   // download PDF file with download method
    //   return $pdf->download('pdf_file.pdf');
    // }


public function generatorPDF() {
    // return 'came';
    $user_id = auth()->id();
    // dd($user_id);
    $user = User::findOrFail($user_id);
    $selection=array();
    if(Seller::where('user_id', $user_id)->exists()){
        $seller=Seller::where('user_id', $user_id)->first();

        foreach (($seller->verification_info) as  $element) {
            $selection[$element['label']]=$element['value'];
        }
    }
    // dd($seller->user_id);
    //  dd($selection);
    // $seller=Seller::findOrFail($user_id);
    $date=Carbon::parse($seller->created_at)->format('d-m-Y');
            // dd($date);



            // ->with('selection', $selection)->with('seller', $seller)->with('date', $date)


    $pdf = PDF::loadView('frontend.user.seller.pdf.pdf_file', compact('selection', 'date', 'seller')); // <--- load your view into theDOM wrapper;
    return $pdf->stream('downlaod.pdf');
    return back();
  }
}




    //  $array=[$selection,$user_id,$date];
        // dd($array);
    //  dd($user->id);

    // $array=['selection','user_id','date'];
    // dd($array);

    // $user->user_id=12;
    //  dd($array);
    //   dd($array[0]['Форма_собственности']);
    // view()->share('employee',$user);

    // $array = array();
    // $data = array();
    // $i = 0;
    // foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
    //     $item = array();
    //     if ($element->type) {
    //         $item['type'] = $element->type;
    //         $item['label'] = $element->label;
    //         $item['value'] = $request[$element->label];
    //         $array[$element->label] = $request[$element->label];
    //     }
    //     array_push($data, $item);
    //     $i++;
    // }
    // // dd($data);
    // $seller->user_id = $user_id;
    // $seller->verification_info = json_encode($data);
    // //  dd($user_id);
    // $shop->user_id =$user_id;
    // $shop->name = $request->Название_магазина;
    // $shop->address = $request->Адрес_регистрации_вендора;
    // $shop->slug = SlugService::createSlug(Shop::class, 'slug', slugify($request->Название_магазина));
    // // dd($shop);
    // //   dd($seller->verification_info);
    // $date = Carbon::parse($seller->created_at)->format('d-m-Y');
    // // dd($array);
    // // dd($date);
    // if ($user->save()) {
    //     if ($seller->save()) {
    //         if($shop->save()){
    //             return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller', $seller)->with('date', $date);
    //         }
    //     }
    // }
// 'frontend.user.seller.seller_delivery')->with('seller', $selection)->with('user_id', $user_id)->with('date', $date);
