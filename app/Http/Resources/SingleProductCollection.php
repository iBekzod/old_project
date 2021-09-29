<?php

namespace App\Http\Resources;

use App\Cart;
use App\Characteristic;
use App\Order;
use App\OrderDetail;
use App\Review;
use App\Wishlist;
use App\Attribute;
use App\Color;
use App\Element;
use App\Variation;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class SingleProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $product=$this->first();
        $variation=Variation::withTrashed()->find($product->variation_id);
        $element=Element::withTrashed()->find($product->element_id);
        $user_related=[];
        if(Auth::check()){
            $user_id=auth()->id();
            $user_related=[
                // 'review_count'=>(integer)Review::where('user_id', $user_id)->where('product_id', $product->id)->count(),
                // 'cart_count'=>Cart::where('user_id', $user_id)->where('product_id', $product->id)->count(),
                'is_wishlist'=> Wishlist::where('user_id', $user_id)->where('product_id', $product->id)->exists(),
            ];
        }
        return [
            'id' =>  $product->id,
            'name' => $product->name, // KERE
            'slug' => $product->slug,  // KERE
            'photos' => $this->convertPhotos(explode(',', $element->photos)),  // KERE
            'thumbnail_image' => api_asset($variation->thumbnail_img),
            // 'currency_code'=>defaultCurrency(),
            // 'exchange_rate'=>defaultExchangeRate(),
            // 'base_price' => (double) homeBasePrice($product->id),
            // 'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
            // 'discount' => (integer) $product->discount,
            // 'discount_type' => $product->discount_type,
            // 'todays_deal' => (integer) $product->todays_deal,  // ILYOS AKA BILADI
            // 'featured' =>(integer) $product->featured,  // ILYOS AKA BILADI
            'rating' => (double) $product->rating, // YULDUZCHA
            // 'qty' => (integer) $product->qty,
            'review_count'=>(integer)Review::where('product_id', $product->id)->count(), // OTZIF
            // 'earn_point'=>($product->earn_point!=0)?$product->earn_point:calculateProductClubPoint($product->id),
            'user_related'=> $user_related,
            // 'choice_options' => $this->convertToChoiceOptions($variation->characteristics),
            // 'color'=>($variation && $variation->color_id)?new ColorCollection(Color::where('id', $variation->color_id)->get()):null,
            // 'brand' => [
            //     'name' => $element != null ? $element->brand->getTranslation('name'):null,
            //     'slug' => $element != null ? $element->brand->slug : null,
            //     'logo' => $element != null ? api_asset($element->brand->logo) : null,
            // ],
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
                'attribute'=>$characteristic->attribute->name,
            ];
        }
        return $data;
    }


    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
