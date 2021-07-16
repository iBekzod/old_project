<?php

namespace App\Http\Resources;

use App\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ParentCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //TODO:Pass here only sub sub categories
        $sub_sub_categories = $this->collection;
        foreach ($sub_sub_categories as $sub_sub_category) {
            $sub_sub_category['sub_category'] = $sub_sub_category->parent->id;
            $sub_sub_category['category'] = $sub_sub_category->parent->parent->id;
        }
        $sub_sub_categories = $sub_sub_categories->groupBy(['category', 'sub_category']);
        $data = [];
        $data_sub_category = [];
        $data_sub_sub_category = [];
        foreach ($sub_sub_categories as $category_id => $sub_categories) {
            foreach ($sub_categories as $sub_category_id => $sub_sub_categories) {
                foreach ($sub_sub_categories as $sub_sub_category) {
                    $sub_sub_category_brands = brandsOfCategory($sub_sub_category->id);
                    $data_sub_sub_category[] = [
                        'id' => $sub_sub_category->id,
                        'name' => $sub_sub_category->getTranslation('name'),
                        'slug' => $sub_sub_category->slug,
                        'banner' => $sub_sub_category->banner ? api_asset($sub_sub_category->banner) : 'public/images/default-image.jpg',
                        'icon' => api_asset($sub_sub_category->icon),
                        'featured' => $sub_sub_category->featured,
                        'parent' => $sub_sub_category->parent,
                        'brands' => (count($sub_sub_category_brands) > 0) ? new BrandCollection($sub_sub_category_brands) : [],
                        'links' => [
                            'products' => route('api.products.category', $sub_sub_category->id),
                            'sub_categories' => route('subCategories.index', $sub_sub_category->id)
                        ]
                    ];
                }
                $sub_category = Category::where('id', $sub_category_id)->first();
                $sub_category_brands = brandsOfCategory($sub_category->id);
                $data_sub_category = [
                    'id' => $sub_category->id,
                    'name' => $sub_category->getTranslation('name'),
                    'slug' => $sub_category->slug,
                    'banner' => $sub_category->banner ? api_asset($sub_category->banner) : 'public/images/default-image.jpg',
                    'icon' => api_asset($sub_category->icon),
                    'featured' => $sub_category->featured,
                    'children' => $data_sub_sub_category,
                    'brands' => (count($sub_category_brands) > 0) ? new BrandCollection($sub_category_brands) : [],
                    'links' => [
                        'products' => route('api.products.category', $sub_category->id),
                        'sub_categories' => route('subCategories.index', $sub_category->id)
                    ]
                ];
            }

            $category = Category::where('id', $category_id)->first();
            $category_brands = brandsOfCategory($category->id);
            $data[] = [
                'id' => $category->id,
                'name' => $category->getTranslation('name'),
                'slug' => $category->slug,
                'banner' => $category->banner ? api_asset($category->banner) : 'public/images/default-image.jpg',
                'icon' => api_asset($category->icon),
                'featured' => $category->featured,
                'children' => $data_sub_category,
                'brands' => (count($category_brands) > 0) ? new BrandCollection($category_brands) : [],
                'links' => [
                    'products' => route('api.products.category', $category->id),
                    'sub_categories' => route('subCategories.index', $category->id)
                ]
            ];
        }
        return [
            'data' => $data
        ];
    }

    public function with($request)
    {
        return [
            'lang' => app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}
