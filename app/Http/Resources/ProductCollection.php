<?php

namespace App\Http\Resources;

use App\ProductStock;
use App\ProductTranslation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $lang = ProductTranslation::where('product_id', $data->id)->where('lang', app()->getLocale())->first();

                $arr =  [
                    'id'=>$data->id,
                    'slug'=>$data->slug,
                    'owner_id' => $data->user_id,
                    'name' => $data->name,
                    'photos' => explode(',', $data->photos),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'base_price' => (double) homeBasePrice($data->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($data->id),
                    'todays_deal' => (integer) $data->todays_deal,
                    'featured' =>(integer) $data->featured,
                    'unit' => $data->unit,
                    'discount' => (integer) $data->discount,
                    'discount_type' => $data->discount_type,
                    'rating' => (double) $data->rating,
                    'sales' => (integer) $data->num_of_sale,
                    'variant' => ProductStock::where('product_id', $data->id)->first(),
                    'variations' => ProductStock::where('product_id', $data->id)->get(),
                    'links' => [
                        'details' => route('products.show', $data->id),
                        'reviews' => route('api.reviews.index', $data->id),
                        'related' => route('products.related', $data->id),
                        'top_from_seller' => route('products.topFromSeller', $data->id)
                    ]
                ];

                if ($lang) {
                    $arr['name'] = $lang->name;
                }

                return $arr;
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
