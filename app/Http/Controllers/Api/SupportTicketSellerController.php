<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\ConversationCollection;
 use App\SupportService;
use App\User;
use Auth;

class SupportTicketSellerController extends Controller
{

    public function postSupportTicketSeller(Request $request)
    {
        $request->validate([
            'code'=>'required',
            
            'user_id'=>'sometimes',
            'name' => 'required|min:3',
            'phone' => 'required|min:8|max:13',
            'email' => 'required',
            'message'=> 'required'
         ]);
         $support_service=SupportService::firstOrNew([
                       'user_id'=>$request->user_id,
                       'name'=>$request->name,
                       'phone'=>$request->phone,
                       'email'=>$request->email,
                       'message'=>$request->message
                   ]);
          if($support_service->save()){
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