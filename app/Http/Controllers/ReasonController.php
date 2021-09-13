<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessSetting;
use App\Order;
use App\RefundRequest;
use App\OrderDetail;
use App\Reason;
use App\Seller;
use App\Shop;
use App\Wallet;
use App\User;
use Auth;

class ReasonController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Store Customer Refund Request




    public function index()
    {
        $reasons = Reason::where('reason_status',0)->latest()->paginate(15);
        // dd($reasons);
        return view('refund_request.reasons.reason', compact('reasons'));
    }
}
