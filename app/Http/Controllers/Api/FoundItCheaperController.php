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
            'user_id'=>'required',
            'email' => 'required',
            'links'=> 'required',
            'price'=> 'required'

         ]);

       
         $found_it_cheaper=FoundItCheaper::firstOrNew([
                       'user_id'=>$request->user_id,
                       'email'=>$request->email,
                       'links'=>$request->links,
                       'price'=>$request->price
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

