<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketCollection;
use Illuminate\Http\Request;
use App\Ticket;
use App\User;
use Auth;
use App\TicketReply;
use App\Mail\SupportMailManager;
use Mail;
class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function post_store(Request $request)
    {
        if($request->has('code') && $request->code!=null){
            $code = $request->code;
        }else{
            $code = max(100000, (Ticket::latest()->first() != null ? Ticket::latest()->first()->code + 1 : 0)).date('s');
        }
        $ticket = Ticket::firstOrNew(['code'=>$code, 'user_id'=>auth()->id()]);
        $ticket->subject = $request->subject;
        $ticket->details = $request->details;
        $ticket->files = $request->attachments;
        if($ticket->save()){
            $this->send_support_mail_to_admin($ticket);
            return response()->json([
                'code'=>$code,
                'status'=>true,
                'message' => translate('Ticket has been sent successfully')
           ]);
        }
        else{
            return response()->json([
                'code'=>$code,
                'status'=>false,
                'message' => translate('Something went wrong')
           ]);
        }
    }

    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(15);
        return new TicketCollection($tickets);
    }

    public function show($code)
    {
        $tickets = Ticket::where('user_id', auth()->id())->where('code', $code)->orderBy('created_at', 'desc')->get();
        return new TicketCollection($tickets);
    }

    public function send_support_mail_to_admin($ticket){
        $array['view'] = 'emails.support';
        $array['subject'] = 'Support ticket Code is:- '.$ticket->code;
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = 'Hi. A ticket has been created. Please check the ticket.';
        $array['link'] = route('support_ticket.show', encrypt($ticket->id));
        $array['sender'] = $ticket->user->name;
        $array['details'] = $ticket->details;

        // dd($array);
        // dd(User::where('user_type', 'admin')->first()->email);
        try {
            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new SupportMailManager($array));
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }
    }

}