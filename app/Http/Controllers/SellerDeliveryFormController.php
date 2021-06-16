<?php

namespace App\Http\Controllers;

use App\Seller;
use Illuminate\Http\Request;

class SellerDeliveryFormController extends Controller
{
   public function seller_delivery_form_save(Request $request)
   {
        //    dd($request->all());
           $selection=json_decode($request->seller_document);
        // //   dd($selection);
        //  $data=$request->created_at;
        //  dd($data);
        $time=time();
        $date=date("d/m/Y",$time);
       return view('frontend.user.seller.seller_delivery')->with('seller',$selection)->with('date',$date);
   }


}
