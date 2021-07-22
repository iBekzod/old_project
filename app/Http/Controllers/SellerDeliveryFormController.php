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
    $user = User::findOrFail($user_id);
    $selection=array();
    if(Seller::where('user_id', $user_id)->exists()){
        $seller=Seller::where('user_id', $user_id)->first();

        foreach (($seller->verification_info) as  $element) {
            $selection[$element['label']]=$element['value'];
        }
    }
    // dd($selection);
    // $seller=Seller::findOrFail($user_id);
    $date=Carbon::parse($seller->created_at)->format('d-m-Y');
            // dd($date);

    //   $path = public_path('pdf_docs/'); // <--- folder to store the pdf documents into the server;
    //   $fileName =  time().'.'. 'pdf' ; // <--giving the random filename,
    //   $pdf->save($path . '/' . $fileName);
    //   $generated_pdf_link = url('pdf_docs/'.$fileName);
    //   return response()->json($generated_pdf_link);

     $array=[$selection,$user_id,$date];
        // dd($array);
    //  dd($user->id);

    // $array=['selection','user_id','date'];
    // dd($array);

    // $user->user_id=12;
    //  dd($array);
    //   dd($array[0]['Форма_собственности']);
    // view()->share('employee',$user);


    $pdf = PDF::loadView('frontend.user.seller.pdf.pdf_file'); // <--- load your view into theDOM wrapper;
    return $pdf->stream('downlaod.pdf');
    return back();
  }
}

// 'frontend.user.seller.seller_delivery')->with('seller', $selection)->with('user_id', $user_id)->with('date', $date);
