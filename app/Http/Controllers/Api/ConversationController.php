<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Mail\ConversationMailManager;
use App\Message;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationCollection;
use App\User;
use Auth;

class ConversationController extends Controller
{
    public function getConversations()
    {
        $conversation = Conversation::where('sender_id', auth()->id())->orWhere('receiver_id',  auth()->id())->orderBy('created_at', 'desc')->paginate(15);
        // dd($conversation);
        return new ConversationCollection($conversation);
    }
    public function postConversations(Request $request)
    {



        $request->validate([
            'user_id'=>'required',
            'type'=>'required',
            'product_id' => 'required',
            'msg' => 'required'
         ]);
        //  dd($request->all());
          $conversation = new Conversation;

          $conversation->sender_id =$request->user_id;
          $conversation->receiver_id = $request->product_id;
          $conversation->type = $request->type??'conversation';
          $conversation->msg =$request->msg;
        //    dd($conversation);
          if($conversation->save()){
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

    public function show()
    {
        $conversation = Conversation::where('sender_id', auth()->id())->orWhere('receiver_id',auth()->id())->orderBy('created_at', 'desc')->get();
        return new ConversationCollection($conversation);

    }
}

