<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $product=$data->product;
                $address=$product->user->addresses->first();
                return [
                    'quantity' => $data->quantity,
//                    'delivery_type' => $data->delivery_type,
                    'price' => $data->price,
                    'product' => $product,
                    'user' => [                        
                        'id' => $product->user->id,
                        'phone' => $product->user->phone,
                        'name' => $product->user->name,
                        'email' => $product->user->email,
                        'avatar' => $product->user->avatar,
                        'avatar_original' => api_asset($product->user->avatar_original),
                        'shop_name' => $product->added_by == 'admin' ? '' : $product->user->shop->name,
                        'shop_logo' => $product->added_by == 'admin' ? '' : api_asset($product->user->shop->logo),
                        'shop_link' => $product->added_by == 'admin' ? '' : route('shops.info', $product->user->shop->id),
                    ],
                    'address'=>[
                        'address'=>$address->address,
                        'country'=>$address->region->name,
                        'city'=>$address->city->name,
                        'postal_code'=> $address->postal_code,
                        'phone'=>$address->phone,
                        'longitude'=>$address->longitude??getDefaultLongitude(),
                        'latitude'=>$address->latitude??getDefaultLatitude()
                    ]
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
