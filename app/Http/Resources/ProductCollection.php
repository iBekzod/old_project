<?php

namespace App\Http\Resources;

use App\Element;
use App\Product;
use App\Variation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $product=Product::findOrFail($data->id);
                $variation=Variation::findOrFail($product->variation_id);
                $element=Element::findOrFail($variation->element_id);
                $products=Product::where('variation_id', $product->variation_id)->get();
                return [
                    'id'=>$product->id,
                    'slug'=>$product->slug,
                    'owner_id' => $product->user_id,
                    'name' => $variation->name,
                    'photos' => $this->convertPhotos(explode(',', $element->photos)),
                    'thumbnail_image' => api_asset($variation->thumbnail_img),
                    'base_price' => (double) homeBasePrice($product->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
                    'currency_code'=>defaultCurrency(),
                    'exchange_rate'=>defaultExchangeRate(),
                    'todays_deal' => (integer) $product->todays_deal,
                    'featured' =>(integer) $product->featured,
                    'unit' => $element->unit,
                    'discount' => (integer) $product->discount,
                    'discount_type' => $product->discount_type,
                    'rating' => (double) $product->rating,
                    'sales' => (integer) $variation->num_of_sale,
                    'qty' => (integer) $variation->qty,
                    'variant' => $product,
                    'variations' => $products,
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
            'lang'=> app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }

    protected function convertPhotos($variation){
        $result = array();
        foreach ($variation as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
