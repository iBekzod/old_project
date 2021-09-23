<?php

namespace App\Http\Resources;

use App\Review;
use App\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseHistoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'code' => $data->code,
                    'user' => [
                        'name' => $data->user->name,
                        'email' => $data->user->email,
                        'avatar' => $data->user->avatar,
                        'avatar_original' => api_asset($data->user->avatar_original)
                    ],
                    // 'product'=>[
                    //     'list_of_images'=>($data->orderDetail)?$this->convertPhotos(explode(',', $data->orderDetail->product->element->photos)):'',
                    //     'price'=>(double)$data->orderDetail->price,
                    //     'discount'=>(int)((double)($data->order->coupon_discount/$data->refund_amount)*100),
                    //     'discount_price'=>(double)$data->order->coupon_discount,
                    //     'name'=>$data->orderDetail->product->name,
                    //     'ranking'=>$data->orderDetail->product->rating,
                    //     'list_of_review'=>new ReviewCollection(Review::where('product_id', $data->orderDetail->product->id)->where('user_id', $data->user_id)->get()) ,
                    //     'is_wishlist'=> Wishlist::where('product_id',$data->orderDetail->product->id)->where('user_id', $data->user_id)->exists(),
                    //     'product_id'=>$data->orderDetail->product->id,
                    // ],
                    'shipping_address' => json_decode($data->shipping_address),
                    'payment_type' => str_replace('_', ' ', $data->payment_type),
                    'payment_status' => $data->payment_status,


                    'delivery_status' => $data->delivery_status,
                    'grand_total' => (double) $data->grand_total,
                    'coupon_discount' => (double) $data->coupon_discount,
                    'shipping_cost' => (double) $data->orderDetails->sum('shipping_cost'),
                    'subtotal' => (double) $data->orderDetails->sum('price'),
                    'tax' => (double) $data->orderDetails->sum('tax'),
                    'date' => Carbon::createFromTimestamp($data->date)->format('d-m-Y'),
                    'links' => [
                        'details' => route('purchaseHistory.details', $data->id)
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
    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
