<?php

namespace App\Http\Resources;

use App\Element;
use App\FlashDealProduct;
use App\Product;
use App\Variation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        // dd($request);
        return [
            'data' => $this->collection->map(function($data) {
                try {
                    $product=Product::find($data->id);
                    $variation=Variation::find($product->variation_id);
                    $element=Element::find($variation->element_id);
                    $products=Product::where('variation_id', $product->variation_id)->get();
                } catch (\Exception $th) {
                    return null;//($th->getMessage());
                }
                return [
                    'id'=>$product->id,
                    'slug'=>$product->slug,
                    'owner_id' => $product->user_id,
                    'name' => $variation->name,
                    'photos' => $this->convertPhotos(explode(',', $element->photos)),
                    'thumbnail_image' => api_asset($variation->thumbnail_img),
                    'earn_point'=>($product->earn_point!=0)?$product->earn_point:calculateProductClubPoint($product->id),
                    'base_price' => (double) homeBasePrice($product->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
                    'shipping_type' => $product->delivery_type,
                    'shipping_cost' => $this->calculateShippingCost($product),
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
                    'flashDeal'=> FlashDealProduct::where('product_id', $product->id)->first()??[],
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

    protected function calculateShippingCost($product, $is_express=false){
        $address=getUserAddress();
        return calculateDeliveryCost($product, $address->id, $is_express);
    }
}
