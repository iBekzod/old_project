<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ReportDescription;



class ReportDescriptionController extends Controller
{

    public function postReportDescription(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'email' => 'required',
            'comment'=> 'required',
         ]);
         $report_description=ReportDescription::firstOrNew([
                       'user_id'=>$request->user_id,
                       'email'=>$request->email,
                       'comment'=>$request->comment,
                   ]);
          if($report_description->save()){
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
