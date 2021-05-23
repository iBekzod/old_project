<?php

namespace App\Http\Resources;

use App\Element;
use App\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $element=Element::findOrFail($data->element_id);
                $product=Product::findOrFail($data->lowest_price_id);
                return [
                    'id'=>$data->id,
                    'slug'=>$data->slug,
                    'owner_id' => $product->user_id,
                    'name' => $data->name,
                    'photos' => explode(',', $element->photos),
                    'thumbnail_image' => api_asset($data->thumbnail_image),
                    'base_price' => (double) homeBasePrice($data->lowest_price_id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($data->lowest_price_id),
                    'todays_deal' => (integer) $product->todays_deal,
                    'featured' =>(integer) $product->featured,
                    'unit' => $element->unit,
                    'discount' => (integer) $product->discount,
                    'discount_type' => $product->discount_type,
                    'rating' => (double) $product->rating,
                    'sales' => (integer) $data->num_of_sale,
                    // 'variant' => ProductStock::where('product_id', $data->id)->first(),
                    // 'variations' => ProductStock::where('product_id', $data->id)->get(),
                    'links' => [
                        'details' => route('products.show', $data->id),
                        'reviews' => route('api.reviews.index', $data->id),
                        'related' => route('products.related', $data->id),
                        'top_from_seller' => route('products.topFromSeller', $data->id)
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
}
