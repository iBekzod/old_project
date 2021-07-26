<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Review;
use App\Attribute;
use App\Branch;
use App\Characteristic;
use App\Element;
use App\FlashDealProduct;
use App\Product;
use App\User;
use App\Variation;

class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $product=Product::where('slug', $request->id)->first();
        if(!($product->is_accepted && $product->published)){
            return [];
        }
        $variation=Variation::withTrashed()->find($product->variation_id);
        $products=getPublishedProducts('product', ['where'=>[['variation_id', $variation->id]]], [], []);
        $element=Element::withTrashed()->find($variation->element_id);
        $seller_products=getPublishedProducts('product', ['where'=>[['user_id', $product->user_id],['element_id', $product->element_id]]], [], [])->get();
        try{
            $data = [
                'express_shipping_cost'=>$this->calculateShippingCost($product, true),
                'id' => (integer) $product->id,
                'name' => $variation->getTranslation('name'),
                'added_by' => $product->added_by,
                'variant' => $this->makeVariation($product)??[],
                'variations' => $this->makeVariations($product)??[],
                'user' => [
                    'name' => $product->user->name,
                    'email' => $product->user->email,
                    'avatar' => $product->user->avatar,
                    'avatar_original' => api_asset($product->user->avatar_original),
                    'shop_name' => $product->added_by == 'admin' ? '' : $product->user->shop->name,
                    'shop_logo' => $product->added_by == 'admin' ? '' : api_asset($product->user->shop->logo),
                    'shop_link' => $product->added_by == 'admin' ? '' : route('shops.info', $product->user->shop->id)
                ],
                'selers'=>$this->getSellers($product),
                'brand' => [
                    'name' => $element != null ? $element->brand->getTranslation('name'):null,
                    'slug' => $element != null ? $element->brand->slug : null,
                    'logo' => $element != null ? api_asset($element->brand->logo) : null,
                    'links' => [
                        'products' => route('api.products.brand', $element->brand->id)
                    ]
                ],
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
                'tax' => (double) $product->tax,
                'tax_type' => $product->tax_type,
                'rating' => (double) $product->rating,
                'number_of_sales' => (integer) $product->num_of_sale,
                'current_stock' => (integer) $product->qty,
                'tag' => explode(',', $element->tags),
                'slug' => $product->slug,
                'unit' => $element->unit,
                'qty'=>$product->qty,
                'video_link' => $element->video_link,
                'video_provider' => $element->video_provider,
                'rating' => (double) $product->rating,
                'rating_count' => (integer) Review::where(['product_id' => $product->id])->count(),
                'description' => $element->getTranslation('description'),
                'reviews' => new ReviewCollection(Review::where('product_id', $product->id)->latest()->get()),
                'price_lower' => (double) convertCurrency($products->min('price'), $product->currency_id),
                'price_higher' => (double) convertCurrency($products->max('price'), $product->currency_id),
                // 'choice_options' => $this->convertToChoiceOptions(json_decode($product->variation, true), $product),
                'choice_options' => $this->convertToChoiceOptions($seller_products),
                'short_characteristics' => $this->convertToShortCharacteristics(json_decode($element->characteristics)),
                'colors' => new ProductColorCollection(json_decode($element->variation_colors)),
                'shipping_type' => $product->delivery_type,
                'shipping_cost' => $this->calculateShippingCost($product),
                'characteristics' => $this->convertToCharacteristics(json_decode($element->characteristics, true)),

                'flashDeal'=> FlashDealProduct::where('product_id', $product->id)->first()??[],
                'category'=>[
                    'name' => $element->category->getTranslation('name'),
                    'banner' => api_asset($element->category->banner),
                    'icon' => $element->category->icon,
                    'links' => [
                        'products' => route('api.products.category', $element->category_id),
                        'sub_categories' => route('subCategories.index', $element->category_id)
                    ]
                ],
                'links' => [
                    'reviews' => route('api.reviews.index', $product->id),
                    'related' => route('products.related', $product->id)
                ],
            ];
        } catch (\Exception $th) {
            // dd($th->getMessage());
            // return null;
            return ($th->getTrace());
        }
        return $data;
    }

    public function with($request)
    {
        return [
            'breadcrumbs' => [
                $this->collection
            ],
            'lang'=> app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }

    protected function convertToCharacteristics($attributes){
        $result=array();
        $collected_characteristics=[];
        if ($attributes) {
            foreach($attributes as $attribute_id=>$value_ids){
                $characteristics=Characteristic::withTrashed()->whereIn('id',$value_ids)->get();
                $attribute=Attribute::withTrashed()->where('id',$attribute_id)->first();
                $branch=Branch::where('id',$attribute->branch_id)->first();
                if(!(isset($attribute) && isset($branch))){
                    continue;
                }
                $items=array();
                foreach($characteristics as $characteristic){
                    $items[]=[
                        'id'=>$characteristic->id,
                        'name'=>$characteristic->getTranslation('name')
                    ];
                }
                $collected_characteristics['id']=$attribute->id;
                $collected_characteristics['attribute']=$attribute->getTranslation('name');
                $collected_characteristics['values']=$items;
                if( is_array($items) && count($items)>0){
                    $result[]=[
                        'id'=>$branch->id,
                        'title'=>$branch->getTranslation('name'),
                        'options'=>$collected_characteristics
                    ];
                }
            }

            foreach($result as $key => $value){
                $newarray[$value['id']]['id'] = $value['id'];
                $newarray[$value['id']]['title'] = $value['title'];
                $newarray[$value['id']]['options'][$key] = $value['options'];
            }
            return $newarray;
        }
        return $result;
    }

    protected function convertToShortCharacteristics($attributes, $number=10){
        $collected_characteristics=[];
        if ($attributes) {
            foreach($attributes as $attribute_id=>$value_ids){
                if( is_array($value_ids) && count($value_ids)>0){
                    $characteristics=Characteristic::withTrashed()->whereIn('id',$value_ids)->get();
                    $attribute=Attribute::withTrashed()->where('id',$attribute_id)->first();
                    if(!(isset($attribute))){
                        continue;
                    }
                    $items=array();
                    foreach($characteristics as $characteristic){
                        $items[]=[
                            'id'=>$characteristic->id,
                            'name'=>$characteristic->getTranslation('name')
                        ];
                    }
                    if( is_array($items) && count($items)==1 && $number>0){
                        $collected_characteristics[]=[
                            'id'=>$attribute->id,
                            'attribute'=>$attribute->getTranslation('name'),
                            'values'=>$items
                        ];
                        $number--;
                    }
                }
            }
        }
        return $collected_characteristics;
    }

    protected function convertToChoiceOptions($products){
        $color_ids=[];
        $characteristic_ids=[];
        if(count($products)>0){
            foreach($products as $product){
                if($product->variation->characteristics)$characteristic_ids=array_unique(array_merge($characteristic_ids, explode(',', $product->variation->characteristics)));
                if($product->color_id)$color_ids=array_unique(array_merge($color_ids, $product->color_id));
            }
            $attributes=Characteristic::withTrashed()->whereIn('id', $characteristic_ids)->get()->groupBy('attribute_id');
            $collected_characteristics=[];
            // dd($characteristic_ids);
            if ($attributes) {
                foreach($attributes as $attribute_id=>$models){
                    if( is_array($models) && count($models)>0){
                        $characteristics=$models;
                        $attribute=Attribute::withTrashed()->where('id',$attribute_id)->first();
                        if(!(isset($attribute))){
                            continue;
                        }
                        $items=array();
                        foreach($characteristics as $characteristic){
                            $items[]=[
                                'id'=>$characteristic->id,
                                'is_active'=>hasSuchAttribute($product, $characteristic->id),
                                'name'=>$characteristic->getTranslation('name')
                            ];
                        }
                        // dd($items);
                        if( is_array($items) && count($items)>0){
                            $collected_characteristics[]=[
                                'id'=>$attribute->id,
                                'attribute'=>$attribute->getTranslation('name'),
                                'values'=>$items
                            ];
                        }
                    }
                }
            }
        }

        return $collected_characteristics;
    }
    // protected function convertToChoiceOptions($attributes, $product){
    //     $collected_characteristics=[];
    //     // dd($attributes);
    //     if ($attributes) {
    //         foreach($attributes as $attribute_id=>$value_ids){

    //             if( is_array($value_ids) && count($value_ids)>0){
    //                 $characteristics=Characteristic::withTrashed()->whereIn('id', $value_ids)->get();
    //                 $attribute=Attribute::withTrashed()->where('id',$attribute_id)->first();
    //                 if(!(isset($attribute))){
    //                     continue;
    //                 }
    //                 $items=array();
    //                 foreach($characteristics as $characteristic){
    //                     $items[]=[
    //                         'id'=>$characteristic->id,
    //                         'is_active'=>hasSuchAttribute($product, $characteristic->id),
    //                         'name'=>$characteristic->getTranslation('name')
    //                     ];
    //                 }
    //                 // dd($items);
    //                 if( is_array($items) && count($items)>0){
    //                     $collected_characteristics[]=[
    //                         'id'=>$attribute->id,
    //                         'attribute'=>$attribute->getTranslation('name'),
    //                         'values'=>$items
    //                     ];
    //                 }
    //             }
    //         }
    //     }
    //     return $collected_characteristics;
    // }

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }

    protected function makeVariations($product){
        $products=Product::where('element_id', $product->element_id)->where('user_id', $product->user_id)->get();
        $variations=array();
        foreach($products as $product){
            $variation=$product->variation;
            $variations[]=[
                'slug'=>$product->slug??null,
                'attributes'=>array_map(function($v){ return (int)$v; }, explode(",",$variation->characteristics)??null),
                'color'=>$variation->color_id??null
            ];
        }
        return $variations;
    }

    protected function makeVariation($product){
        $variation=$product->variation;
        return [
            'slug'=>$product->slug??null,
            'attributes'=>array_map(function($v){ return (int)$v; }, explode(",",$variation->characteristics)??null),
            'color'=>$variation->color_id??null,
            'photos' => $this->convertPhotos(explode(',', $variation->photos)),
            'thumbnail_image' => api_asset($variation->thumbnail_img),
        ];
    }


    protected function getSellers($item){
        $products=Product::where('variation_id', $item->variation_id)->get();
        $sellers=array();
        foreach($products as $product){
            $sellers[]=[
                'product'=>[
                    'id' => (integer) $product->id,
                    'thumbnailImage' => $product->added_by == 'admin' ? api_asset(get_setting('system_logo_black'))??static_asset('assets/img/logo.png') : api_asset($product->user->shop->logo),
                    'name' => $product->variation->getTranslation('name'),
                    'variant' => $this->makeVariation($product)??[],
                    'base_price' => (double) homeBasePrice($product->id),
                    'base_discounted_price' => (double) homeDiscountedBasePrice($product->id),
                    'currency_code'=>defaultCurrency(),
                    'exchange_rate'=>defaultExchangeRate(),
                    'discount' => (integer) $product->discount,
                    'discount_type' => $product->discount_type,
                    'slug' => $product->slug,
                    'links' => [
                        'reviews' => route('api.reviews.index', $product->id),
                        'related' => route('products.related', $product->id)
                    ],
                ],
                'name' => $product->user->name,
                'shipping_type' => $product->delivery_type,
                'shipping_cost' => $this->calculateShippingCost($product),
                'is_current'=>($item->id==$product->id),
                'seller_name' => $product->user->name,
                'email' => $product->user->email,
                'avatar' => $product->user->avatar,
                'avatar_original' => api_asset($product->user->avatar_original),
                'shop_name' => $product->added_by == 'admin' ? '' : $product->user->shop->name,
                'shop_logo' => $product->added_by == 'admin' ? '' : uploaded_asset($product->user->shop->logo),
                'shop_link' => $product->added_by == 'admin' ? '' : route('shops.info', $product->user->shop->id)
            ];
        }
        return $sellers;
    }

    protected function calculateShippingCost($product, $is_express=false){
        // return 20000;
        // dd(request()->ip());
        if($product->delivery_type=='free'){
            return 0;
        }else {
            $address=getUserAddress();
            return calculateDeliveryCost($product, $address->id, $is_express);
            // return calculateShipping(['product_id'=>$product->id, 'type'=>'precise', 'address_id'=>$address->id]);
        }

    }
}
