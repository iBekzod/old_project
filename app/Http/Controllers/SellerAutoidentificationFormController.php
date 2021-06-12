<?php

namespace App\Http\Controllers;

use App\Seller;
use App\SellerAutoidntification;
use Illuminate\Http\Request;

class SellerAutoidentificationFormController extends Controller
{
   public function seller_autoidentification_form_save(Request $request)
   {
        $array=$request->all();
        dd($array);

        $request->validate([
            // TODO::tak seller navicatdatoldirish kere inn validate save and login register pdf to html
        ]);

          $seller= new Seller;

        //  return view('frontend.user.seller.seller_autoidentification')->with('seller', $array);


   }


}
