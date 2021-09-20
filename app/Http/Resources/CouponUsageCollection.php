<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CouponUsageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'code'=>[
                        'id'=>$data->coupon->id,
                        'type'=>$data->coupon->type,
                        'code'=>$data->coupon->code,
                        'start_date'=>date("Y-m-d H:i:s", $data->coupon->start_date),
                        'end_date'=>date("Y-m-d H:i:s", $data->coupon->end_date)
                    ],
                    'created_at'=>$data->created_at
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'lang'=>app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}

