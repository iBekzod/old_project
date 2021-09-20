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
        $ticket = new Ticket;
        if($request->has('code') && $request->code!=null){
            $code = $request->code;
        }else{
            $code = max(100000, (Ticket::latest()->first() != null ? Ticket::latest()->first()->code + 1 : 0)).date('s');
        }
        $ticket->code = $code;
        $ticket->user_id = auth()->id();
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
        // // dd($request->all());
        // $request->validate([
        //     'code'=>'required',
        //     'subject' => 'required',
        //     'details' => 'required',
        //     'file' => 'sometimes',
        //     'status'=> 'required'
        //  ]);
        //  $data=[
        //     'code'=>$request->code,
        //     'user_id'=>auth()->id(),
        //     'subject'=>$request->subject,
        //     'details'=>$request->details,
        //     'files'=>$request->file,
        //     'status'=>$request->status
        //  ];
        // //  dd($data);
        //  $support_ticket=Ticket::firstOrNew($data);

        //   if($support_ticket->save()){
        //     return response()->json([
        //         'message' => translate('Message has been send to seller')
        //    ]);
        //   }
        //   else{
        //     return response()->json([
        //         'message' => translate('error')
        //    ]);
        //   }

    }

    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(15);
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



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail(decrypt($id));
        // $ticket->client_viewed = 1;
        // $ticket->save();
        $ticket_replies = $ticket->ticketreplies;
        return view('frontend.user.support_ticket.show', compact('ticket','ticket_replies'));
    }
}
