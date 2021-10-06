<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategorySubCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $brands=brandsOfCategory($data->id);
                return [
                    'id'=>$data->id,
                    'name' => $data->getTranslation('name'),
                    'banner' => $data->banner ? api_asset($data->banner) : 'public/images/default-image.jpg',
                    'slug' => $data->slug,
                    'icon' => api_asset($data->icon),
                    'brands' => (count($brands)>0)?new BrandCollection($brands):[],
                    'sub_categories' => $data->categories,
                    'links' => [
                        'products' => route('api.products.category', $data->id),
                        'sub_categories' => route('subCategories.index', $data->id)
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
}
