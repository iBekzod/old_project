<?php

namespace App\Http\Resources;

use App\Color;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $product=$data->product;                
                $element=$product->element;
                $variation=$product->variation;
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
                    ],    
                    'brand' => [
                        'name' => $element != null ? $element->brand->getTranslation('name'):null,
                        'slug' => $element != null ? $element->brand->slug : null,
                        'logo' => $element != null ? api_asset($element->brand->logo) : null,
                    ],
                    'color'=>($variation && $variation->color_id)?Color::where('id', $variation->color_id)->first():null,
                    'photos' => ($element && $element->photos)?$this->convertPhotos(explode(',', $element->photos)):[],
                    'thumbnail_image' => ($variation && $variation->thumbnail_img)?api_asset($variation->thumbnail_img):[],
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
