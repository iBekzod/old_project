<?php

namespace App\Http\Resources\V2;

use App\Color;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseHistoryItemsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $product=$data->product;
                $address=$product->user->addresses->first();
                return [
                    'product_id' => $data->product->id,
                    'product_name' => $data->product->name,
                    'variation' => $data->variation,
                    'price' => format_price($data->price),
                    'tax' => format_price($data->tax),
                    'shipping_cost' =>format_price($data->shipping_cost),
                    'coupon_discount' => format_price($data->coupon_discount),
                    'quantity' => (int) $data->quantity,
                    'payment_status' => $data->payment_status,
                    'payment_status_string' => ucwords(str_replace('_', ' ', $data->payment_status)),
                    'delivery_status' => $data->delivery_status,
                    'delivery_status_string' => $data->delivery_status == 'pending'? "Order Placed" : ucwords(str_replace('_', ' ',  $data->delivery_status)),
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
                    ],    
                    'brand' => [
                        'name' => $product->element != null ? $product->element->brand->getTranslation('name'):null,
                        'slug' => $product->element != null ? $product->element->brand->slug : null,
                        'logo' => $product->element != null ? api_asset($product->element->brand->logo) : null,
                        'links' => [
                            'products' => route('api.products.brand', $product->element->brand->id)
                        ]
                    ],
                    'color'=>($product->variation->color_id)?Color::where('id', $product->variation->color_id)->first():null,
                    'photos' => $this->convertPhotos(explode(',', $product->element->photos)),
                    'thumbnail_image' => api_asset($product->variation->thumbnail_img),
                    'earn_point'=>($product->earn_point!=0)?$product->earn_point:calculateProductClubPoint($product->id),
                    'base_price' => (double) homeBasePrice($product->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
                    'currency_code'=>defaultCurrency(),
                    'exchange_rate'=>defaultExchangeRate(),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
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
