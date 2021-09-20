<?php

namespace App\Http\Resources;

use App\Review;
use App\Wishlist;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RefundRequestCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'product'=>[
                        'list_of_images'=>$this->convertPhotos(explode(',', $data->orderDetail->product->element->photos)),
                        'price'=>$data->refund_amount,
                        'discount'=>$data->order->coupon_discount,
                        'discount_price'=>$data->order->coupon_discount,
                        'name'=>$data->orderDetail->product->name,
                        'ranking'=>$data->orderDetail->product->rating,
                        'list_of_review'=>new ReviewCollection(Review::where('product_id', $data->orderDetail->product->id)->where('user_id', $data->user_id)->get()) ,
                        'is_wishlist'=> Wishlist::where('product_id',$data->orderDetail->product->id)->where('user_id', $data->user_id)->exists(),
                        'product_id'=>$data->orderDetail->product->id,
                    ],
                    'user_id' => $data->user_id,
                    'order' => $data->order,
                    'order_detail' => $data->orderDetail,
                    'seller_id' => $data->seller_id,
                    'admin_approval' => $data->admin_approval,
                    'seller_approval' => $data->seller_approval,
                    'refund_amount' => $data->refund_amount,
                    'reason' => $data->reason,
                    'reason_id' => $data->my_reason,
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

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
