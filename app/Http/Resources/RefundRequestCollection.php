<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RefundRequestCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'user_id' => $data->user_id,
                    'order_id' => $data->order_id,
                    'order_detail_id' => $data->order_detail_id,
                    'seller_id' => $data->seller_id,
                    'admin_approval' => $data->admin_approval,
                    'seller_approval' => $data->seller_approval,
                    'refund_amount' => $data->refund_amount,
                    'reason' => $data->reason,
                    'reason_id' => $data->reason_id,
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
