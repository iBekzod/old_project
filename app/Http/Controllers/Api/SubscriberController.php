<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Mail\ConversationMailManager;
use App\Message;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationCollection;
use App\Subscriber;
use App\User;
use Auth;



class SubscriberController extends Controller
{

    public function postSubscribers(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'email' => 'required'
         ]);

         $subscriber=Subscriber::firstOrNew([
                       'email'=>$request->email
                   ]);
          if($subscriber->save()){
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

