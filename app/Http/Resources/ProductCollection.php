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



                    // $table->string('added_by', 6)->nullable();
                    // $table->integer('currency_id')->nullable();
                    // $table->double('price', 20, 2)->default(0.00);
                    // $table->integer('variation_id')->nullable();
                    // $table->integer('delivery_group_id')->nullable();
                    // $table->integer('qty')->default(0);
                    // $table->integer('published')->default(0);
                    // $table->double('tax', 20, 2)->nullable();
                    // $table->string('tax_type', 10)->nullable();
                    // $table->integer('featured')->default(0);
                    // $table->integer('seller_featured')->default(0);
                    // $table->boolean('on_moderation')->default(0);
                    // $table->boolean('is_accepted')->default(1);
                    // $table->string('barcode', 255)->nullable();
                    // $table->double('earn_point', 8, 2)->default(0.00);



                    'id'=>$data->id,
                    'slug'=>$data->slug,
                    'owner_id' => $data->user_id,
                    'name' => $data->name,
                    'photos' => explode(',', $data->photos),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    // 'base_price' => (double) homeBasePrice($data->id),
                    // 'base_discounted_price' => (double) homeDiscountedBasePrice($data->id),
                    'todays_deal' => (integer) $data->todays_deal,
                    'featured' =>(integer) $data->featured,
                    'unit' => $data->unit,
                    // 'discount' => (integer) $data->discount,
                    // 'discount_type' => $data->discount_type,
                    'rating' => (double) $data->rating,
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
