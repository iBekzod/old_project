<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PurchaseHistoryCollection;
use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomOrderDetailCollection;
use App\OrderDetail;
use App\RefundRequest;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        return new PurchaseHistoryCollection(Order::where('user_id', auth()->id())->latest()->get());
    }

    public function boughtProducts(){
        $order_detail_ids=RefundRequest::pluck('order_detail_id');
        $order_ids=Order::where('user_id', auth()->id())->pluck('id');
        $order_details=OrderDetail::whereIn('order_id', $order_ids)
        ->whereNotIn('id', $order_detail_ids)
        // ->where('delivery_status', 'delivered')
        ->where('payment_status', 'paid')->get();
        return new CustomOrderDetailCollection($order_details);
    }

    public function refundedProducts(){
        $order_detail_ids=RefundRequest::where('user_id', auth()->id())->where('refund_status', 1)->pluck('order_detail_id');
        $order_details=OrderDetail::whereIn('id', $order_detail_ids)->get();
        return new CustomOrderDetailCollection($order_details);
    }
}
