<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'product' => [
                        'name' => $data->product->getTranslation('name'),
                        'image' => api_asset($data->product->variation->thumbnail_img)
                    ],
                    'seller' => [
                        'user_id'=>$data->product->user->id,
                        'name' => $data->product->user->name,
                        'email' => $data->product->user->email,
                        'avatar' => $data->product->user->avatar,
                        'avatar_original' => api_asset($data->product->user->avatar_original),
                        'shop_name' => $data->product->added_by == 'admin' ? '' : $data->product->user->shop->name,
                        'shop_logo' => $data->product->added_by == 'admin' ? '' : api_asset($data->product->user->shop->logo),
                        'shop_link' => $data->product->added_by == 'admin' ? '' : route('shops.info', $data->product->user->shop->id)
                    ],
                    'variation' => $data->variation,
                    'price' => (double) $data->price,
                    'weight'=>$data->product->element->weight,
                    'earn_point'=>($data->product->earn_point!=0)?$data->product->earn_point:calculateProductClubPoint($data->product->id),
                    'tax' => (double) $data->tax,
                    'shipping_cost' => (double) $data->shipping_cost,
                    'quantity' => (integer) $data->quantity,
                    'date' => $data->created_at->diffForHumans()
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
