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
    public function getConversations(Request $request)
    {
        /**  TODO::conversation and ticked */
        // $request->validate([
        //     'user_id' => 'required',
        // ]);
        $conversation = Conversation::where('sender_id', auth()->id())->orWhere('receiver_id', $request->user_id)->orderBy('created_at', 'desc')->paginate(15);

        return [
            'data' => $conversation->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'sender_id' => $data->sender_id,
                    'receiver_id' => $data->receiver_id,
                    'title' => $data->title,
                    'type' => $data->type,
                    'sender_viewed' => $data->sender_viewed,
                    'receiver_viewed' => $data->receiver_viewed,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                    'messages'=> $data->messages
                ];
            })
        ];
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

    public function show(Request $request)
    {
        /**  TODO::conversation and ticked */
        // $request->validate([
        //     'user_id' => 'required',
        // ]);
        $conversation = Conversation::where('sender_id', auth()->id())->orWhere('receiver_id', $request->user_id)->orderBy('created_at', 'desc')->get();

        return [
            'data' => $conversation->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'sender_id' => $data->sender_id,
                    'receiver_id' => $data->receiver_id,
                    'title' => $data->title,
                    'type' => $data->type,
                    'sender_viewed' => $data->sender_viewed,
                    'receiver_viewed' => $data->receiver_viewed,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                    'messages'=> $data->messages
                ];
            })
        ];
    }
}

