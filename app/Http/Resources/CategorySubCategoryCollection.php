<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategorySubCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
//                try {
                return [
                    'id'=>$data->id,
                    'name' => $data->name,
                    'banner' => $data->banner ? api_asset($data->banner) : 'public/images/default-image.jpg',
                    'icon' => api_asset($data->icon),
                    // 'brands' => brandsOfCategory($data->id),
                    'sub_categories' => $data->categories,
                    'links' => [
                        'products' => route('api.products.category', $data->id),
                        'sub_categories' => route('subCategories.index', $data->id)
                    ]
                ];
//                }catch (\Exception $e) {
//                    return [];
//                }
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
