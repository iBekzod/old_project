<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\BusinessSetting;
use App\FoundItCheaper;
use App\Message;
use Auth;
use App\Product;
use Mail;
use App\Mail\ConversationMailManager;
use App\User;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (BusinessSetting::where('type', 'conversation_system')->first()->value == 1) {
            $user_id=Auth::user()->id;
            // dd($user_id);
            $conversations = Conversation::where('sender_id',$user_id)->orWhereHas('product', function ($product) use ($user_id){
                $product->where('user_id', $user_id);
            })->orderBy('created_at', 'desc')->paginate(10);
            // dd($conversations);


            return view('frontend.user.conversations.index', compact('conversations'));
        }
        else {
            flash(translate('Conversation is disabled at this moment'))->warning();
            return back();
        }

        //     $seller_id=Auth::user()->id;
        //     // dd($seller_id);
        //     $conversations=Conversation::latest()->get();
        //     dd($conversations->receiver_id);
        //     return view('frontend.user.conversations.index', compact('conversations'));
        // }
        // else {
        //     flash(translate('Conversation is disabled at this moment'))->warning();
        //     return back();
        // }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function product_queries()
    {
        if (BusinessSetting::where('type', 'conversation_system')->first()->value == 1) {

            // $conversations = Conversation::orderBy('created_at', 'desc')->get();
            // return view('backend.support.conversations.index', compact('conversations'));

            $conversations=Conversation::latest()->paginate(15);
        //    dd($conversations);

        // $string = "Here is use big string of your paragraph or description.";

            // change 15 top what ever text length you want to show.
            //  dd($stringCut);
            //  $endPoint = strrpos($string,12);
            //  dd( $endPoint);
            // $string = $endPoint;
            // substr($stringCut, 0, $endPoint):substr($stringCut, 0);
        // }
        // dd($string);

            // dd( Auth::user()->seller);
            // $conversation = Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();

            return view('backend.support.conversations.index', compact('conversations'));
        }
        else {
            flash(translate('Conversation is disabled at this moment'))->warning();
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin_store(Request $request)
    {
        // return $request->all();

        // return $request->all();
        $message = new Message();

        $message->conversation_id = $request->conversation_id;
        $message->user_id = Auth::user()->id;
        $message->conversation->sender_viewed=0;
        $message->message = $request->message;
        $message->conversation->save();

        if($message->save()){
            flash(translate('Reply has been sent successfully'))->success();
            // $this->send_support_reply_email_to_user($ticket_reply->ticket, $ticket_reply);
        //    manabuni ishlatish kere
            // dd($ticket_reply);
            return back();
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
        // return 'keldi';
        // $user_type = Product::findOrFail($request->product_id)->user->user_type;

        // $conversation = new Conversation;
        // $conversation->sender_id = Auth::user()->id;
        // $conversation->receiver_id = Product::findOrFail($request->product_id)->user->id;
        // $conversation->title = $request->title;

        // if($conversation->save()) {
        //     $message = new Message;
        //     $message->conversation_id = $conversation->id;
        //     $message->user_id = Auth::user()->id;
        //     $message->message = $request->message;

        //     if ($message->save()) {
        //         $this->send_message_to_seller($conversation, $message, $user_type);
        //     }
        // }

        // flash(translate('Message has been send to seller'))->success();
        // return back();
    }
    public function store(Request $request)
    {

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
            //dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = 1;
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->receiver_viewed = 1;
        }
        // dd($conversation);
        $conversation->save();
        return view('frontend.user.conversations.show', compact('conversation'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        $conversation = Conversation::findOrFail(decrypt($request->id));
        if($conversation->sender_id == Auth::user()->id){
            $conversation->sender_viewed = 1;
            $conversation->save();
        }
        else{
            $conversation->receiver_viewed = 1;
            $conversation->save();
        }
        return view('frontend.partials.messages', compact('conversation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_show($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        $conversation->sender_viewed = 1;

        //  dd($conversation);
        if( $conversation->save()){
            return view('backend.support.conversations.show', compact('conversation'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     if($conversation = Conversation::findOrFail(decrypt($id))){
    //         if($conversation){
    //             $conversation->delete();
    //         }
    //         flash(translate('FoundItCheaper has been deleted successfully'))->success();
    //             return back();
    //     }
    // }

     public function destroy($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        if($conversation){
            $conversation->delete();
        }
        flash(translate('Conversation has been deleted successfully'))->success();
        return back();
    }
}
