<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDeliveryFormController extends Controller
{
   public function seller_delivery_form_save(Request $request)
   {
        //    dd($request->all());
           $selection=json_decode($request->seller_document);
         
       return view('frontend.user.seller.seller_delivery')->with('seller',$selection);
   }


}
