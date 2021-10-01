<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomOrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $order_details=[];
                foreach($data->orderDetails as $orderDetail){
                    $product=$orderDetail->product;
                    $order_details[]=[
                        'order_detail_id'=>$orderDetail->id,
                        'name'=>$product->getTranslation('name'),
                        'slug'=>$product->slug,
                        'price'=>$orderDetail->price,
                        'color'=>$product->variation->color->getTranslation('name'),
                        'thumbnail_image' => api_asset($product->variation->thumbnail_img),
                        'quantity'=>$orderDetail->quantity,
                        'shop_name'=>$product->user->shop->name,
                        'seller_phone'=>$product->user->phone
                    ];
                }
                return [
                    'order_id' => $data->id,//order_id
                    'code' => $data->code,//code
                    'payment_status' => $data->payment_status,
                    'delivery_status' => $data->delivery_status,//delivery_status
                    'grand_total' => (double) $data->grand_total,//grnad_total
                    'discount' => $data->coupon_discount,
                    'payment_method' => $data->payment_type,
                    'shipping_address' => json_decode($data->shipping_address),
                    'date' => formatDate($data->created_at),
                    'order_products' => $order_details
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
