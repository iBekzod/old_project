<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\BusinessSetting;
use App\RefundRequest;
use App\OrderDetail;
use App\Reason;
use App\Seller;
use App\Wallet;
use App\User;
use Auth;

class RefundRequestController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Store Customer Refund Request
    public function request_store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'reason_id' => 'required',
            'reason' => 'required',
         ]);
        $order_detail = OrderDetail::where('id', $request->id)->first();
        if(!RefundRequest::where('user_id', $order_detail->order->user_id)->where('order_detail_id',$order_detail->id)->where('order_id',$order_detail->order_id)->exists()){
            if($order_detail->product->refundable && $order_detail->payment_status=='paid'){
                $refund = new RefundRequest;
                $refund->user_id = $order_detail->order->user_id;
                $refund->order_id = $order_detail->order_id;
                $refund->order_detail_id = $order_detail->id;
                $refund->seller_id = $order_detail->seller_id;
                $refund->seller_approval = 0;
                $refund->reason = $request->reason;
                $refund->reason_id=$request->reason_id;
                $refund->admin_approval = 0;
                $refund->admin_seen = 0;
                $refund->refund_amount = 0;// $order_detail->price + $order_detail->tax;
                $refund->refund_status = 0;
                if($reason=Reason::where('id', $request->reason_id)->first()){
                    switch ($reason->responsible) {
                        case 'seller':
                            $refund->refund_amount = $order_detail->price + $order_detail->tax;
                            break;
                        case 'delivery_boy':
                            $refund->refund_amount = $order_detail->price + $order_detail->tax;
                            break;
                        case 'customer':
                            $refund->refund_amount = $order_detail->price + $order_detail->tax;
                            break;

                        default:
                            $refund->refund_amount = $order_detail->price + $order_detail->tax;
                            break;
                    }
                }
                if ($refund->save()) {
                    return response()->json([
                        'data'=>$refund,
                        'status'=>true,
                        'message' =>translate("Refund Request has been sent successfully")
                   ]);
                }

            }
        }
        return response()->json([
            'data'=>[],
            'status'=>false,
            'message' =>translate("Rejected refund request")
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendor_index()
    {
        $refunds = RefundRequest::where('seller_id', Auth::user()->id)->latest()->paginate(10);
        return response()->json([
            'data'=>$refunds,
            'status'=>true,
            'message' =>translate("Refund Request has been sent successfully")
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_index()
    {
        $refunds = RefundRequest::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return response()->json([
            'data'=>$refunds,
            'status'=>true,
            'message' =>translate("Refund Request has been sent successfully")
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_time_update(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'value' => 'required',
         ]);
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        return response()->json([
            'data'=>$business_settings,
            'status'=>true,
            'message' =>translate("Refund Request sending time has been updated successfully")
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_sticker_update(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'logo' => 'required',
         ]);
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->logo;
            $business_settings->save();
        }
        else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->logo;
            $business_settings->save();
        }
        return response()->json([
            'data'=>$business_settings,
            'status'=>true,
            'message' =>translate("Refund Sticker has been updated successfully")
       ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index()
    {
        $refunds = RefundRequest::where('refund_status', 0)->latest()->paginate(15);
        return response()->json([
            'data'=>$refunds,
            'status'=>true,
            'message' =>""
       ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paid_index()
    {
        $refunds = RefundRequest::where('refund_status', 1)->latest()->paginate(15);
        return response()->json([
            'data'=>$refunds,
            'status'=>true,
            'message' =>''
       ]);
    }

    public function rejected_index()
    {
        $refunds = RefundRequest::where('refund_status', 2)->latest()->paginate(15);
        return response()->json([
            'data'=>$refunds,
            'status'=>true,
            'message' =>''
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function request_approval_vendor(Request $request)
    {
        $request->validate([
            'el' => 'required',
         ]);
        $refund = RefundRequest::findOrFail($request->el);
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            $refund->seller_approval = 1;
            $refund->admin_approval = 1;
        }
        else {
            $refund->seller_approval = 1;
        }

        if ($refund->save()) {
            return response()->json([
                'data'=>[],
                'status'=>true,
                'message' =>'success'
           ]);
        }
        else {
            return response()->json([
                'data'=>[],
                'status'=>false,
                'message' =>'failed'

           ]);
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_pay(Request $request)
    {
        $request->validate([
            'el' => 'required',
         ]);
        $refund = RefundRequest::findOrFail($request->el);
        if ($refund->seller_approval == 1) {
            $seller = Seller::where('user_id', $refund->seller_id)->first();
            if ($seller != null) {
                $seller->admin_to_pay -= $refund->refund_amount;
            }
            $seller->save();
        }
        $wallet = new Wallet;
        $wallet->user_id = $refund->user_id;
        $wallet->amount = $refund->refund_amount;
        $wallet->payment_method = 'Refund';
        $wallet->payment_details = 'Product Money Refund';
        $wallet->save();
        $user = User::findOrFail($refund->user_id);
        $user->balance += $refund->refund_amount;
        $user->save();
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            $refund->admin_approval = 1;
            $refund->refund_status = 1;
        }
        if ($refund->save()) {
            return response()->json([
                'data'=>[],
                'status'=>true,
                'message' =>'success'
           ]);
        }
        else {
            return response()->json([
                'data'=>[],
                'status'=>false,
                'message' =>'failed'
           ]);
        }
    }

    public function reject_refund_request(Request $request){
      $refund = RefundRequest::findOrFail($request->refund_id);
      if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
          $refund->admin_approval = 2;
          $refund->refund_status  = 2;
          $refund->reject_reason  = $request->reject_reason;
      }
      else{
          $refund->seller_approval = 2;
          $refund->reject_reason  = $request->reject_reason;
      }

      if ($refund->save()) {
        return response()->json([
            'data'=>[],
            'status'=>true,
            'message' =>translate('Refund request rejected successfully.')
        ]);
      }
      else {
        return response()->json([
            'data'=>[],
            'status'=>false,
            'message' =>'failed'
        ]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refund_request_send_page(Request $request)
    {
        $request->validate([
            'id' => 'required',
         ]);
        $order_detail = OrderDetail::findOrFail($request->id);
        if ($order_detail->product != null && $order_detail->product->refundable == 1) {
            return response()->json([
                'data'=>[],
                'status'=>true,
                'message' =>translate('Refund request rejected successfully.')
            ]);
        }
        else {
            return response()->json([
                'data'=>[],
                'status'=>false,
                'message' =>'failed'
            ]);
        }
    }

    /**
     * Show the form for view the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Shows the refund reason
    public function reason_view(Request $request)
    {
        $request->validate([
            'id' => 'required',
         ]);
        $refund = RefundRequest::findOrFail($request->id);
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            if ($refund->orderDetail != null) {
                return response()->json([
                    'data'=>[],
                    'status'=>true,
                    'message' =>translate('Refund request rejected successfully.')
                ]);
            }
        }
        else {
            return response()->json([
                'data'=>[],
                'status'=>false,
                'message' =>'failed'
            ]);
        }
    }

    public function reject_reason_view(Request $request)
    {
        $request->validate([
            'id' => 'required',
         ]);
        $refund = RefundRequest::findOrFail($request->id);
        return $refund->reject_reason;
    }

}
