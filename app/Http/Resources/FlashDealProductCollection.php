<?php

namespace App\Http\Resources;

use App\ProductStock;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FlashDealProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $product = $data->product;
                return [
                    'id'=>$product->id,
                    'slug'=>$product->slug,
                    'owner_id' => $product->user_id,
                    'name' => $product->name,
                    'photos' => explode(',', $product->photos),
                    'thumbnail_image' => api_asset($product->thumbnail_img),
                    'base_price' => (double) homeBasePrice($product->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
                    'todays_deal' => (integer) $product->todays_deal,
                    'featured' =>(integer) $product->featured,
                    'unit' => $product->unit,
                    'discount' => (integer) $product->discount,
                    'discount_type' => $product->discount_type,
                    'rating' => (double) $product->rating,
                    'sales' => (integer) $product->num_of_sale,
                    'variant' => ProductStock::where('product_id', $product->id)->first(),
                    'variations' => ProductStock::where('product_id', $product->id)->get(),
                    'links' => [
                        'details' => route('products.show', $product->id),
                        'reviews' => route('api.reviews.index', $product->id),
                        'related' => route('products.related', $product->id),
                        'top_from_seller' => route('products.topFromSeller', $product->id)
                    ]
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
}
