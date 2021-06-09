<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerAutoidentificationFormController extends Controller
{
   public function seller_autoidentification_form_save(Request $request)
   {
        $array=$request->all();
       // dd($array);
         return view('frontend.user.seller.seller_autoidentification')->with('seller', $array);


   }


}
