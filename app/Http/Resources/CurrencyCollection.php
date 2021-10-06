<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CurrencyCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'name' => $data->name,
                    'code' => $data->code,
                    'symbol' => $data->symbol,
                    'exchange_rate' => (double) $data->exchange_rate
                ];
            }),
            'default_currency_code'=>defaultCurrency(),
            'default_exchange_rate'=>defaultExchangeRate()
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
