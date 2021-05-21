<?php

namespace App\Http\Resources;
use App\Product;
use App\Element;
use App\ProductTranslation;
use App\VariationTranslation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VariationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'name'=>$data->getTranslation('name'),
                    // 'lowest_price_id'=> new ProductCollection(Product::findOrFail($data->lowest_price_id)),
                    'slug'=>$data->slug,
                   // 'element_id'=> ElementCollection(Element::findOrFail($data->element_id)),
                    'prices'=>$data->prices,
                    'owner_id'=>$data->user_id,
                    'sales'=>$data->num_of_sale,
                    'qty'=>$data->qty,
                    'rating'=>$data->rating

                    // 'name',
                    // 'lowest_price_id',
                    // 'slug',
                    // 'element_id',
                    // 'prices',
                    // 'variant',
                    // 'sku',
                    // 'user_id',
                    // 'num_of_sale',
                    // 'qty',
                    // 'rating',
                    // 'created_at',
                    // 'updated_at',



                    // 'id'=>$data->id,
                    // 'slug'=>$data->slug,
                    // 'owner_id' => $data->user_id,
                    // 'name' => $data->name,
                    // 'photos' => explode(',', $data->photos),
                    // 'thumbnail_image' => api_asset($data->thumbnail_img),
                    // // 'base_price' => (double) homeBasePrice($data->id),
                    // // 'base_discounted_price' => (double) homeDiscountedBasePrice($data->id),
                    // 'todays_deal' => (integer) $data->todays_deal,
                    // 'featured' =>(integer) $data->featured,
                    // 'unit' => $data->unit,
                    // // 'discount' => (integer) $data->discount,
                    // // 'discount_type' => $data->discount_type,
                    // 'rating' => (double) $data->rating,
                    // 'sales' => (integer) $data->num_of_sale,
                    // 'variant' => ProductStock::where('product_id', $data->id)->first(),
                    // 'variations' => ProductStock::where('product_id', $data->id)->get(),
                    // 'links' => [
                    //     'details' => route('products.show', $data->id),
                    //     'reviews' => route('api.reviews.index', $data->id),
                    //     'related' => route('products.related', $data->id),
                    //     'top_from_seller' => route('products.topFromSeller', $data->id)
                    // ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'lang'=>app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}
