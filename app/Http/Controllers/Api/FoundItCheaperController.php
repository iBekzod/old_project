<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\ConversationCollection;
use App\FoundItCheaper;
use App\User;
use Auth;

class FoundItCheaperController extends Controller
{

    public function postFoundItCheaper(Request $request)
    {


        $request->validate([
            'product_id'=>'required',
            'email' => 'required',
            'links'=> 'required',
            'price'=> 'required',
            'currency_id'=>'required'

         ]);
         $found_it_cheaper=FoundItCheaper::firstOrNew([
                       'product_id'=>$request->product_id,
                       'email'=>$request->email,
                       'links'=>$request->links,
                       'price'=>$request->price,
                       'currency_id'=>$request->currency_id
                   ]);
          if($found_it_cheaper->save()){
            return response()->json([
                'message' => translate('Message has been send to seller')
           ]);
          }
          else{
            return response()->json([
                'message' => translate('error')
           ]);
          }


    }

}

