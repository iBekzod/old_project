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
        dd($request);
        // $data=$request;
        // $product=Product::findOrFail($this->id);
        $variation=Variation::findOrFail($request->variation_id);
        $element=Element::findOrFail($variation->element_id);
        return [
            'id' => (integer) $this->id,
            'name' => $this->getTranslation('name'),
            'added_by' => $this->added_by,
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'avatar' => $this->user->avatar,
                'avatar_original' => api_asset($this->user->avatar_original),
                'shop_name' => $this->added_by == 'admin' ? '' : $this->user->shop->name,
                'shop_logo' => $this->added_by == 'admin' ? '' : uploaded_asset($this->user->shop->logo),
                'shop_link' => $this->added_by == 'admin' ? '' : route('shops.info', $this->user->shop->id)
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
            'base_price' => (double) homeBasePrice($this->id),
            'base_discounted_price' => (double) homeDiscountedBasePrice($this->id),
            'currency_code'=>defaultCurrency(),
            'exchange_rate'=>defaultExchangeRate(),
            'todays_deal' => (integer) $this->todays_deal,
            'featured' =>(integer) $this->featured,
            'unit' => $element->unit,
            'discount' => (integer) $this->discount,
            'discount_type' => $this->discount_type,
            'tax' => (double) $this->tax,
            'tax_type' => $this->tax_type,
            'rating' => (double) $this->rating,
            'number_of_sales' => (integer) $this->num_of_sale,
            'current_stock' => (integer) $this->qty,
            'tag' => explode(',', $element->tags),
            'slug' => $this->slug,
            'unit' => $element->unit,
            'video_link' => $element->video_link,
            'video_provider' => $element->video_provider,
            'rating' => (double) $this->rating,
            'rating_count' => (integer) Review::where(['product_id' => $this->id])->count(),
            'description' => $this->getTranslation('description'),
            'reviews' => new ReviewCollection(Review::where('product_id', $this->id)->latest()->get()),

            // 'translations' => ProductTranslation::where('product_id', $data->id)->get(),
            // 'variations' => ProductStock::where('product_id', $data->id)->groupBy('user_id', true)->get(),
            // 'price_lower' => (double) explode('-', homeDiscountedPrice($data->id))[0],
            // 'price_higher' => (double) explode('-', homeDiscountedPrice($data->id))[1],
            // 'choice_options' => $this->convertToChoiceOptions(json_decode($data->choice_options)),
            // 'colors' => new ProductColorCollection(json_decode($element->colors)),
            // 'shipping_type' => $data->shipping_type,
            // 'shipping_cost' => (double) $data->shipping_cost,
            // 'characteristics' => $data->characteristicValuesForDetailProduct,

            'flashDeal'=> FlashDealProduct::where('product_id', $this->id)->firstOrFail()??null,
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
                'reviews' => route('api.reviews.index', $this->id),
                'related' => route('products.related', $this->id)
            ]
        ];
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

    protected function convertToChoiceOptions($data){
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
