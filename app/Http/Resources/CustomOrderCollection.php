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
                $shipping_method='simple';
                foreach($data->orderDetails as $orderDetail){
                    $shipping_method=($orderDetail->variation==1)?'express':'simple';
                    $product=$orderDetail->product;
                    $order_details[]=[
                        'order_detail_id'=>$orderDetail->id,
                        'product_id'=>$orderDetail->id,
                        'name'=>$product->getTranslation('name'),
                        'slug'=>$product->slug,
                        'price'=>$orderDetail->price,
                        'color'=>$product->variation->color->getTranslation('name'),
                        'thumbnail_image' => api_asset($product->variation->thumbnail_img),
                        'quantity'=>$orderDetail->quantity,
                        'shop_name'=>$product->user->shop->name,
                        'brand_name'=>$product->element->brand->getTranslation('name'),
                        'seller_phone'=>$product->user->phone,
                        'shipping_method'=>$shipping_method,
                    ];
                }
                return [
                    'order_id' => $data->id,//order_id
                    'code' => $data->code,//code
                    'payment_status' => $data->payment_status,
                    'delivery_status' => $data->delivery_status,//delivery_status
                    'sub_total'=>$data->orderDetails->sum('price'),
                    // 'total_tax'=>$data->orderDetails->sum('tax'),
                    'total_quantity'=>$data->orderDetails->sum('quantity'),
                    'shipping_cost'=>$data->orderDetails->sum('shipping_cost'),
                    'shipping_method'=>$shipping_method,
                    'grand_total' => (double) $data->grand_total,//grnad_total
                    'discount' => $data->coupon_discount,
                    'payment_method' => $data->payment_type,
                    'date' => formatDate($data->created_at),
                    'shipping_address' => json_decode($data->shipping_address),
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
