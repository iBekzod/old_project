<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDeliveryFormController extends Controller
{
   public function seller_delivery_form_save(Request $request)
   {
        $selection=$request->all();
        dd($selection);
       return view('frontend.user.seller.seller_delivery');
   }


}
