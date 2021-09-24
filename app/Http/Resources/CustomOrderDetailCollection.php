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
                    'product'=>new SingleProductCollection($data->product->first()),
                    'currency_code'=>defaultCurrency(),
                    'exchange_rate'=>defaultExchangeRate(),
                    'base_price' => (double) homeBasePrice($data->product->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($data->product->id),
                    'discount' => (integer) $data->product->discount,
                    'discount_type' => $data->product->discount_type,
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
