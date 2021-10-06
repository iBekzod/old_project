<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'code' => $data->code,
                    'delivery_status' => $data->delivery_status,
                    'grand_total' => (double) $data->grand_total,
                    'commission_calculated' => $data->commision_calculated,
                    'coupon_discount' => $data->coupon_discount,
                    'created_at' => $data->created_at,
                    'user_id' => $data->user_id,
                    'guest_id' => $data->guest_id,
                    'shipping_address' => json_decode($data->shipping_address),
                    'payment_type' => $data->payment_type,
                    'manual_payment' => $data->manual_payment,
                    'manual_payment_data' => $data->manual_payment_data,
                    'payment_status' => $data->payment_status,
                    'payment_details' => $data->payment_details,
                    'grand_total' => $data->grand_total,
                    'date' => $data->date,
                    'viewed' => $data->viewed,
                    'delivery_viewed' => $data->delivery_viewed,
                    'payment_status_viewed' => $data->payment_status_viewed,
                    'updated_at' => $data->updated_at,
                    'ordered_products' => new OrderDetailCollection($data->orderDetails)
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
