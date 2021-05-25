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
                // $lowest_price_list=json_decode($data->lowest_price_id, true);
                // $lowest_price_id=array_rand($lowest_price_list, 1);
                $lowest_price_id=$data->lowest_price_id;
                $element=Element::findOrFail($data->element_id);
                $product=Product::findOrFail($lowest_price_id);
                $products=Product::where('variation_id', $data->id)->get();
                return [
                    'id'=>$data->id,
                    'slug'=>$data->slug,
                    'owner_id' => $product->user_id,
                    'name' => $data->name,
                    'photos' => $this->convertPhotos(explode(',', $element->photos)),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'base_price' => (double) homeBasePrice($lowest_price_id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($lowest_price_id),
                    'todays_deal' => (integer) $product->todays_deal,
                    'featured' =>(integer) $product->featured,
                    'unit' => $element->unit,
                    'discount' => (integer) $product->discount,
                    'discount_type' => $product->discount_type,
                    'rating' => (double) $product->rating,
                    'sales' => (integer) $data->num_of_sale,
                    'variant' => $product,
                    'variations' => $products,
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

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
