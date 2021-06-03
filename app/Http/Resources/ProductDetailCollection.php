<?php

namespace App\Http\Resources;

use App\Attribute as AppAttribute;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Review;
use App\Attribute;
use App\Branch;
use App\Characteristic;
use App\Element;
use App\FlashDealProduct;
use App\Product;
use App\Variation;
use Attribute as GlobalAttribute;

class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $product=Product::where('slug', $request->id)->first();
        $variation=Variation::findOrFail($product->variation_id);
        $products=Product::where('variation_id', $variation->id)->where('user_id', $product->user_id)->get();
        $element=Element::findOrFail($variation->element_id);
        try{
            $data = [
            'id' => (integer) $product->id,
            'name' => $product->getTranslation('name'),
            'added_by' => $product->added_by,
            'user' => [
                'name' => $product->user->name,
                'email' => $product->user->email,
                'avatar' => $product->user->avatar,
                'avatar_original' => api_asset($product->user->avatar_original),
                'shop_name' => $product->added_by == 'admin' ? '' : $product->user->shop->name,
                'shop_logo' => $product->added_by == 'admin' ? '' : uploaded_asset($product->user->shop->logo),
                'shop_link' => $product->added_by == 'admin' ? '' : route('shops.info', $product->user->shop->id)
            ],
            'brand' => [
                'name' => $element != null ? $element->name : null,
                'logo' => $element != null ? api_asset($element->logo) : null,
                'links' => [
                    'products' => $element != null ? route('api.products.brand', $element->brand_id) : null
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
            'description' => $product->getTranslation('description'),
            'reviews' => new ReviewCollection(Review::where('product_id', $product->id)->latest()->get()),
            // 'variations' => $products->groupBy('user_id', true)->get(),
            'price_lower' => (double) convertCurrency($products->min('price'), $product->currency_id),
            'price_higher' => (double) convertCurrency($products->max('price'), $product->currency_id),
            'choice_options' => $this->convertToChoiceOptions(json_decode($element->variations)),
            'colors' => new ProductColorCollection(json_decode($element->variation_colors)),
            'shipping_type' => $product->delivery_type,
            // 'shipping_cost' => $product->delivery,
            'characteristics' => $this->convertToCharacteristics(json_decode($element->characteristics, true)),
            'variant' => $product??[],
            'variations' => $products??[],
            'flashDeal'=> FlashDealProduct::where('product_id', $product->id)->first()??null,
            'category'=>[
                'name' => $element->category->name,
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
                $characteristics=Characteristic::whereIn('id',$value_ids)->get();
                $attribute=Attribute::findOrFail($attribute_id);
                $branch=Branch::findOrFail($attribute->branch_id);
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
            //  var_dump($newarray);
        }
        return $result;
    }

    protected function convertToChoiceOptions($attributes){
        $collected_characteristics=[];
        if ($attributes) {
            foreach($attributes as $attribute_id=>$value_ids){
                if( is_array($value_ids) && count($value_ids)>0){
                    $characteristics=Characteristic::whereIn('id',$value_ids)->get();
                    $attribute=Attribute::findOrFail($attribute_id);
                    $items=array();
                    foreach($characteristics as $characteristic){
                        $items[]=[
                            'id'=>$characteristic->id,
                            'name'=>$characteristic->getTranslation('name')
                        ];
                    }
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
        return $collected_characteristics;
    }

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
