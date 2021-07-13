<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\ConversationCollection;
use App\ReportDescription;
use App\User;
use Auth;



class ReportDescriptionController extends Controller
{

    public function postReportDescription(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'email' => 'required',
            'comment'=> 'required'
         ]);
         $report_description=ReportDescription::firstOrNew([
                       'user_id'=>$request->user_id,
                       'email'=>$request->email,
                       'comment'=>$request->comment
                   ]);
          if($report_description->save()){
            return response()->json([
                'message' => translate('Message has been send to seller ketti')
           ]);
          }
          else{
            return response()->json([
                'message' => translate('error')
           ]);
          }


    }


    // public function postFoundItCheaper(Request $request)
    // {


    //     $request->validate([
    //         'product_id'=>'required',
    //         'email' => 'required',
    //         'links'=> 'required',
    //         'price'=> 'required',
    //         'currency_id'=>'required'

    //      ]);
    //      $found_it_cheaper=FoundItCheaper::firstOrNew([
    //                    'product_id'=>$request->product_id,
    //                    'email'=>$request->email,
    //                    'links'=>$request->links,
    //                    'price'=>$request->price,
    //                    'currency_id'=>$request->currency_id
    //                ]);
    //       if($found_it_cheaper->save()){
    //         return response()->json([
    //             'message' => translate('Message has been send to seller')
    //        ]);
    //       }
    //       else{
    //         return response()->json([
    //             'message' => translate('error')
    //        ]);
    //       }


    // }
}

