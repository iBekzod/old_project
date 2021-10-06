<?php

namespace App\Http\Resources;

use App\RefundRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
//Order detail
class CustomOrderDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'product'=>new SingleProductCollection($data->product),
                    'currency_code'=>defaultCurrency(),
                    'exchange_rate'=>defaultExchangeRate(),
                    'price' => $data->price, //ZAKAZ NARXI
                    // 'quantity' => $data->quantity,
                    // 'tax' => $data->tax,
                    'payment_status' => $data->payment_status,
                    // 'payment_status_string' => ucwords(str_replace('_', ' ', $data->payment_status)),
                    'delivery_status' => $data->delivery_status,
                    // 'delivery_status_string' => $data->delivery_status == 'pending'? "Order Placed" : ucwords(str_replace('_', ' ',  $data->delivery_status)),
                    'on_refund'=>RefundRequest::where('order_detail_id', $data->id)->exists(),
                    'refund_status'=>($data->delivery_status=='cancelled')?1:0,
                    'refundable'=>$data->product->refundable,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'lang'=> app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}
