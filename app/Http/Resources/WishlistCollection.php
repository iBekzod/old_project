<?php

namespace App\Http\Resources;

use App\Element;
use App\Product;
use App\Variation;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
                if($data->product) {
                    return [
                        'id' => (integer) $data->id,
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
                            'links' => [
                                'details' => route('products.show', $product->id),
                                'reviews' => route('api.reviews.index', $product->id),
                                'related' => route('products.related', $product->id),
                                'top_from_seller' => route('products.topFromSeller', $product->id)
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
