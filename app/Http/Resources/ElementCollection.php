<?php

namespace App\Http\Resources;

use App\Element;
use App\Product;
use App\Variation;
use Exception;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ElementCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                try{
                $element=Element::findOrFail($data->id);
                $variation=Variation::where('element_id', $element->id)->where('lowest_price_id', '<>', null)->inRandomOrder()->first();
                $lowest_price_id=$variation->lowest_price_id;
                $product=Product::findOrFail($lowest_price_id);
                $products=Product::where('variation_id', $data->id)->get();
                }catch(Exception $e){
                    return null;
                }
                return [
                    'id'=>$data->id,
                    'slug'=>$product->slug,
                    'owner_id' => $product->user_id,
                    'name' => $data->name,
                    'photos' => $this->convertPhotos(explode(',', $element->photos)),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'base_price' => (double) homeBasePrice($lowest_price_id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($lowest_price_id),
                    'currency_code'=>defaultCurrency(),
                    'exchange_rate'=>defaultExchangeRate(),
                    'todays_deal' => (integer) $product->todays_deal,
                    'featured' =>(integer) $product->featured,
                    'unit' => $element->unit,
                    'discount' => (integer) $product->discount,
                    'discount_type' => $product->discount_type,
                    'rating' => (double) $product->rating,
                    'sales' => (integer) $data->num_of_sale,
                    'qty' => (integer) $data->qty,
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
