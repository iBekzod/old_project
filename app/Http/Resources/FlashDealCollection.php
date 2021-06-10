<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;

class FlashDealCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $flash_deal = FlashDeal::where('id', $this->collection->first()->id)->firstOrFail();
        $ids = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->pluck('product_id');
        $product_conditions['whereIn'][]=['id'=>$ids];
        $products = getPublishedProducts('product', $product_conditions)->get();
        $min_price =($products->count()>0)? homeDiscountedBasePrice($products[0]->id) : 0;
        $max_price = ($products->count()>0)? homeDiscountedBasePrice($products[0]->id) : 0;
        foreach($products as $product){
            $unit_price=homeDiscountedBasePrice($product->id);
            if($min_price>$unit_price){
                $min_price=$unit_price;
            }
            if($max_price<$unit_price){
                $max_price=$unit_price;
            }
        }
        return [
            'title' => $flash_deal->title,
            'slug'=>$flash_deal->slug,
            'end_date' => $flash_deal->end_date,
            'min_price'=>$min_price,
            'max_price'=>$max_price,
            'currency_code'=>defaultCurrency(),
            'exchange_rate'=>defaultExchangeRate(),
            'products' => new ProductCollection($products),
        ];

        // $flash_deal = FlashDeal::findOrFail($this->collection->first()->id);
        // $products = collect();
        // foreach ($flash_deal->flashDealProducts as $key => $flash_deal_product) {
        //     if(Product::find($flash_deal_product->product_id) != null){
        //             $products->push(Product::find($flash_deal_product->product_id));
        //     }
        // }
        // $min_price = ($products)->min('unit_price');
        // $max_price = ($products)->max('unit_price');
        // return [
        //     'title' => $flash_deal->title,
        //     'end_date' => $flash_deal->end_date,
        //     'products' => new ProductCollection($products),
        //     'min_price'=>$min_price,
        //     'max_price'=>$max_price,
        //     'slug'=>$flash_deal->slug,
        // ];
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
