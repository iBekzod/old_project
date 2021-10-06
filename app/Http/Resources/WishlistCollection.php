<?php

namespace App\Http\Resources;

use App\Element;
use App\Product;
use App\Variation;
use App\Wishlist;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WishlistCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                try {
                    $product=Product::findOrFail($data->product_id);
                    $variation=Variation::findOrFail($product->variation_id);
                    $element=Element::findOrFail($variation->element_id);
                } catch (\Exception $th) {
                    return null;//($th->getMessage());
                }
                $wishlist=false;
                if(Auth::check()){
                    $user_id=auth()->id();
                    $wishlist= Wishlist::where('user_id', $user_id)->where('product_id', $product->id)->exists();
                }
                if($data->product) {
                    return [
                        'id' => (integer) $data->id,
                        'weight'=>$element->weight,
                        'discount' => (integer) $product->discount,
                        'discount_type' => $product->discount_type,
                        'user' => [
                            'name' => $product->user->name,
                            'email' => $product->user->email,
                            'avatar' => $product->user->avatar,
                            'avatar_original' => api_asset($product->user->avatar_original),
                            'shop_name' => $product->added_by == 'admin' ? '' : $product->user->shop->name,
                            'shop_logo' => $product->added_by == 'admin' ? '' : api_asset($product->user->shop->logo),
                            'shop_link' => $product->added_by == 'admin' ? '' : route('shops.info', $product->user->shop->id)
                        ],
                        'shipping_type' => $product->delivery_type,
                        'shipping_cost' => $this->calculateShippingCost($product),
                        'product_id' => $product->id,
                        'name' => $product->getTranslation('name'),
                        'slug' => $product->slug,
                        'thumbnail_image' => api_asset($variation->thumbnail_img),
                        'base_price' => (double) homeBasePrice($product->id),
                        'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
                        'currency_code'=>defaultCurrency(),
                        'exchange_rate'=>defaultExchangeRate(),
                        'unit' => $element->unit,
                        'rating' => (double) $product->rating,
                        'is_wishlist'=>$wishlist,
                        'links' => [
                            'details' => route('products.show', $product->id),
                            'reviews' => route('api.reviews.index', $product->id),
                            'related' => route('products.related', $product->id),
                            'top_from_seller' => route('products.topFromSeller', $product->id)
                        ]
                    ];
                }
                return null;
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

    protected function calculateShippingCost($product, $is_express=false){
        $address=getUserAddress();
        return calculateDeliveryCost($product, $address->id, $product->delivery_type);
    }
}
