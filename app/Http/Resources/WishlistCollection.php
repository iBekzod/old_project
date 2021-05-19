<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WishlistCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                if($data->product) {
                    return [
                        'id' => (integer) $data->id,
                            'product_id' => $data->product->id,
                            'name' => $data->product->name,
                            'slug' => $data->product->slug,
                            'thumbnail_image' => api_asset($data->product->thumbnail_img),
                            'base_price' => (double) homeBasePrice($data->product->id),
                            'base_discounted_price' => (double) homeDiscountedBasePrice($data->product->id),
                            'unit' => $data->product->unit,
                            'rating' => (double) $data->product->rating,
                            'links' => [
                                'details' => route('products.show', $data->product->id),
                                'reviews' => route('api.reviews.index', $data->product->id),
                                'related' => route('products.related', $data->product->id),
                                'top_from_seller' => route('products.topFromSeller', $data->product->id)
                            ]
                        ];
                }
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
