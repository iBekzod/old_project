<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'quantity' => $data->quantity,
//                    'delivery_type' => $data->delivery_type,
                    'price' => $data->price,
                    'product' => $data->product,
                    'user' => [                        
                        'seller_id' => $data->product->user->id,
                        'name' => $data->product->user->name,
                        'email' => $data->product->user->email,
                        'avatar' => $data->product->user->avatar,
                        'avatar_original' => api_asset($data->product->user->avatar_original),
                        'shop_name' => $data->product->added_by == 'admin' ? '' : $data->product->user->shop->name,
                        'shop_logo' => $data->product->added_by == 'admin' ? '' : api_asset($data->product->user->shop->logo),
                        'shop_link' => $data->product->added_by == 'admin' ? '' : route('shops.info', $data->product->user->shop->id)
                    ],
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
