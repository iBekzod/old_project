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
                    'code'=>$data->coupon,
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

