<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Mail\ConversationMailManager;
use App\Message;
use App\Product;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
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

        flash(translate('Message has been send to seller'))->success();
        return back();
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
