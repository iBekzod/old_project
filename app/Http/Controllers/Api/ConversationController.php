<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Mail\ConversationMailManager;
use App\Message;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationCollection;
use Auth;

class ConversationController extends Controller
{
    public function getConversations(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $conversation = Conversation::where('sender_id', $request->user_id)->orWhere('receiver_id', $request->user_id)->orderBy('created_at', 'desc')->get();
        // if ($conversation->sender_id == Auth::user()->id) {
        //     $conversation->sender_viewed = 1;
        // }
        // elseif($conversation->receiver_id == Auth::user()->id) {
        //     $conversation->receiver_viewed = 1;
        // }
        // $conversation->save();
        //return new ConversationCollection($conversation);

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
        $request->validate([
             'user_id'=>'required',
            'product_id' => 'required',
            'type'=>'required',
            'message' => 'required',

        ]);
        $support_ticket = new Conversation;
         $support_ticket->sender_id =$request->user_id;
        $support_ticket->receiver_id = Product::findOrFail($request->product_id)->user->id;
        $support_ticket->type = $request->type;
        $support_ticket->message = $request->message;

        $support_ticket->save();
        flash(translate('Message has been send to seller'))->success();
        return response()->json([
            'message' => translate('Message has been send to seller')
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'title' => 'required',
            'message' => 'required',
        ]);

        $user_type = Product::findOrFail($request->product_id)->user->user_type;

        $conversation = new Conversation;
        $conversation->sender_id = Auth::user()->id;
        $conversation->receiver_id = Product::findOrFail($request->product_id)->user->id;
        $conversation->title = $request->title;

        if($conversation->save()) {
            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = Auth::user()->id;
            $message->message = $request->message;

            if ($message->save()) {
                $this->send_message_to_seller($conversation, $message, $user_type);
            }
        }

        //flash(translate('Message has been send to seller'))->success();
        return response()->json([
            'message' => translate('Message has been send to seller')
        ]);
    }

    public function send_message_to_seller($conversation, $message, $user_type)
    {
        $array['view'] = 'emails.conversation';
        $array['subject'] = 'Sender:- '.Auth::user()->name;
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = 'Hi! You recieved a message from '.Auth::user()->name.'.';
        $array['sender'] = Auth::user()->name;

        if($user_type == 'admin') {
            $array['link'] = route('conversations.admin_show', encrypt($conversation->id));
        } else {
            $array['link'] = route('conversations.show', encrypt($conversation->id));
        }

        $array['details'] = $message->message;

        try {
            Mail::to($conversation->receiver->email)->queue(new ConversationMailManager($array));
        } catch (\Exception $e) {
            return ($e->getMessage());
        }
    }
}

