<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Seller;
use App\Shop;
use App\User;

class SellerDeliveryFormController extends Controller
{
   public function seller_delivery_form_save(Request $request)
   {
            //  dd($request->all());
           $selection=json_decode($request->seller_document);
            $user=$selection->user_id;
            // dd($user);
        //    dd($selection);
          $date=$request->date;

        //  dd($data);
        // $time=time();
        // $date=date("d/m/Y",$time);
       return view('frontend.user.seller.seller_delivery')->with('seller',$selection)->with('date',$date)->with('user_id', $user);
   }
   public function seller_page_form_save(Request $request)
   {

       $request->validate([
        'user_id'=>'required'
       ]);
        //  dd($request->all());
    $user_id=$request->user_id;
    $user = User::findOrFail($user_id);
//     if( $seller = Seller::findOrFail($user)==false){
//   return 'error';
//     }
    // $seller = Seller::findOrFail(decrypt($user));
    // $users = $seller->user;
    // dd($users);
    auth()->login($user, true);
    return view('frontend.user.seller.dashboard');

    // if( auth()){
    //     return redirect('seller.login.id')->with('seller_id',$user_id);
    // }
   }


}
