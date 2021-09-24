<?php

namespace App\Http\Resources;

use App\Cart;
use App\Characteristic;
use App\Order;
use App\OrderDetail;
use App\Review;
use App\Wishlist;
use App\Attribute;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class SingleProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $user_related=[];
        if(Auth::check()){
            $user_id=auth()->id();
            $belongs_to_user=[['user_id', $this->$user_id], ['product_id', $this->id]];
            $user_related=[
                'review_count'=>(integer)Review::where($belongs_to_user)->count(),
                'cart_count'=>Cart::where($belongs_to_user)->count(),
                'is_wishlist'=> Wishlist::where($belongs_to_user)->exists(),
            ];
        }
        return [
            'id' => (integer) $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'photos' => $this->convertPhotos(explode(',', $this->element->photos)),
            'thumbnail_image' => api_asset($this->variation->thumbnail_img),
            // 'currency_code'=>defaultCurrency(),
            // 'exchange_rate'=>defaultExchangeRate(),
            // 'base_price' => (double) homeBasePrice($this->id),
            // 'base_discounted_price' => (double) homeDiscountedBasePrice($this->id),
            // 'discount' => (integer) $this->discount,
            // 'discount_type' => $this->discount_type,
            'todays_deal' => (integer) $this->todays_deal,
            'featured' =>(integer) $this->featured,
            'rating' => (double) $this->rating,
            'qty' => (integer) $this->qty,
            'review_count'=>(integer)Review::where('product_id', $this->id)->count(),
            'earn_point'=>($this->earn_point!=0)?$this->earn_point:calculateProductClubPoint($this->id),
            'user_related'=> $user_related,
            'choice_options' => $this->convertToChoiceOptions($this->variation->characteristics),
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

    protected function convertToChoiceOptions($characteristics){
        $characteristics=Characteristic::withTrashed()->whereIn('id', explode(',', $characteristics))->get();
        $data=[];
        foreach($characteristics as $characteristic){
            $data[]=[
                'characteristic_id'=>$characteristic->id,
                'characteristic'=>$characteristic->getTranslation('name'),
                'attribute_id'=>$characteristic->attribute_id,
                'attribute'=>$characteristic->attribute->getTranslation('name'),
            ];
        }
        return $data;
    }
}
