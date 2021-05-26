<?php

namespace App\Http\Resources;

use App\Attribute as AppAttribute;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Review;
use App\Attribute;
use App\Element;
use App\FlashDealProduct;
use App\Product;
use App\Variation;

class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $product=Product::where('slug', $request->id)->first();
        $variation=Variation::findOrFail($product->variation_id);
        $products=Product::where('variation_id', $product->variation_id);
        $element=Element::findOrFail($variation->element_id);
        // try{
        return [
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
            'video_link' => $element->video_link,
            'video_provider' => $element->video_provider,
            'rating' => (double) $product->rating,
            'rating_count' => (integer) Review::where(['product_id' => $product->id])->count(),
            'description' => $product->getTranslation('description'),
            'reviews' => new ReviewCollection(Review::where('product_id', $product->id)->latest()->get()),
            // 'variations' => $products->groupBy('user_id', true)->get(),
            // 'price_lower' => (double) homeBasePrice($products->min('price')),
            // 'price_higher' => (double) homeBasePrice($products->max('price')),
            'choice_options' => $this->convertToChoiceOptions(json_decode($element->variations)),
            'colors' => new ProductColorCollection(json_decode($element->variation_colors)),
            'shipping_type' => $product->delivery_type,
            // 'shipping_cost' => $product->delivery,
            'characteristics' => $this->convertToCharacteristics(json_decode($element->characteristics, true)),

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
        // } catch (\Exception $th) {
        //     dd($th->getMessage());
        // }
        // return $data;
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

    protected function convertToCharacteristics($characteristics){


        return null;
    }

    protected function convertToChoiceOptions($data){
        return null;
        $result = array();
        foreach ($data as $key => $choice) {
            $attr = Attribute::find($choice->attribute_id);
            if($attr && $choice->values!=null)
            {
                $item['name'] = $choice->attribute_id;
                $item['title'] = Attribute::find($choice->attribute_id)->name;
                $item['options'] = $choice->values;
                if($item['name']!=null && $item['title']!=null){
                    array_push($result, $item);
                }

            }
        }
        return $result;
    }

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
