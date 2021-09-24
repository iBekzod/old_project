<?php

namespace App\Http\Resources;

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
                    'base_price' => (double) homeBasePrice($this->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($this->id),
                    'discount' => (integer) $this->discount,
                    'discount_type' => $this->discount_type,
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
