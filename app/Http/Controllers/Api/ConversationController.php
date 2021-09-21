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
        return new ConversationCollection($conversation);
    }
    public function postConversations(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'user_id'=>'required',
            'type'=>'required',
            'product_id' => 'required',
            'msg' => 'required'
         ]);
          $support_ticket = new Conversation;

          $support_ticket->sender_id =$request->user_id;

          $support_ticket->receiver_id = $request->product_id;
          $support_ticket->type = $request->type??'conversation';
          $support_ticket->msg = json_encode($request->msg);

          if($support_ticket->save()){
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

