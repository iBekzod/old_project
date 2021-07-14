<?php

namespace App\Http\Resources;

use App\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
//                try {
                $children=[];
                if($data->level==0 || $data->level==1){
                    $children = new CategoryCollection(Category::where('parent_id', $data->id)->get());
                }
                $brands=brandsOfCategory($data->id);
                return [
                    'id'=>$data->id,
                    'name' => $data->getTranslation('name'),
                    'slug' => $data->slug,
                    'banner' => $data->banner ? api_asset($data->banner) : 'public/images/default-image.jpg',
                    'icon' => api_asset($data->icon),
                    'featured'=>$data->featured,
                    'children'=>$children,
                    'brands' => (count($brands)>0)?new BrandCollection($brands):[],
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
            'lang'=> app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}
