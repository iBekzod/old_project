<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\SearchController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategorySubCategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SearchProductCollection;
use App\Attribute;
use App\Category;
use App\Http\Resources\ProductColorCollection;
use App\Product;
use App\Seller;
use App\Utility\CategoryUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $category = Category::where('slug', $id)
            ->with(['products', 'childrenCategories', 'parentCategoryHierarchy'])
            ->firstOrFail();

        $category_collection = new CategoryCollection($category->childrenCategories);
        $category_collection->additional['filter'] = $this->searchByAttrs($request, $id);
        $category_collection->additional['category'] = Category::where('id', $id)->orWhere('slug', $id)->with('parent')->first();
        $category_collection->additional['category']['tag'] = $this->getTags($category->childrenCategories);
        $category_collection->additional['category']['brands'] = $this->getBrands($category->childrenCategories);
        $category_collection->additional['category']['min_price'] = filter_products(\App\Product::query())->get()->min('price');
        $category_collection->additional['category']['max_price'] = filter_products(\App\Product::query())->get()->max('price');
        $category_collection->additional['category']->banner = api_asset($category_collection->additional['category']->banner);
        $category_collection->additional['category']['breadcrumbs'] = $category->parentCategoryHierarchy;

        if($category->parentCategoryHierarchy) {
            function innerCategory($category, &$breadcrumbs)
            {
                $breadcrumbs[] = $category;
                if($category->parentCategoryHierarchy) {
                    innerCategory($category->parentCategoryHierarchy, $breadcrumbs);
                }
            }

            $breadcrumbs = [];
            $breadcrumbs[] = $category->parentCategoryHierarchy;
            if($category->parentCategoryHierarchy->parentCategoryHierarchy) {
                innerCategory($category->parentCategoryHierarchy->parentCategoryHierarchy, $breadcrumbs);
            }
            foreach ($breadcrumbs as $item) {
                unset($item->parentCategoryHierarchy);
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            $category_collection->additional['category']['breadcrumbs'] = $breadcrumbs;
        }

        return $category_collection;
    }

    public function subCategories($id)
    {

        $category = Category::where('slug',  $id )
            ->with('products')
            ->firstOrFail();

        $category_collection = new CategorySubCategoryCollection($category->categories);

        return $category_collection;
    }

    public function getTags($category)
    {
        $products = $category->map(function ($item) {
            return $item->products->all();
        });
        $array = [];
        foreach ($products as $value) {
            foreach ($value as $item) {
                $array[] = $item;
            }
        }
        $tags = [];
        foreach ($array as $item) {
            $data = explode(',', $item->tags);
            foreach ($data as $item2) {
                $tags[] = $item2;
            }
        }

        return $tags;
    }

    public function getBrands($category)
    {
        $products = $category->map(function ($item) {
            return $item->products->all();
        });

        $array = [];

        foreach ($products as $value) {
            foreach ($value as $item) {
                $array[] = $item;
            }
        }

        $brands = [];
          foreach ($array as $item) {
            if(!in_array($item->brand, $brands))
            {
                $data = $item->brand;
                $brands[] = $data;
            }
        }

        return $brands;
    }

    public function searchByAttrs($request, $id)
    {
        $category = \App\Category::where('id', $id)->orWhere('slug', $id)->first();

        if ($category != null) {
            return $this->search($request, $category->id);
        }

        abort(404);
    }

    public function search($request, $category_id = null, $brand_id = null)
    {
        $query = $request->q;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        // if($min_price != null && $max_price != null){
        //     $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        // }




        // $non_paginate_products = filter_products($products)->get();

        // //Attribute Filter

        // $attributes = array();
        // foreach ($non_paginate_products as $key => $product) {
        //     if($product->attributes != null && is_array(json_decode($product->attributes))){
        //         foreach (json_decode($product->attributes) as $key => $value) {
        //             $flag = false;
        //             $pos = 0;
        //             foreach ($attributes as $key => $attribute) {
        //                 if($attribute['id'] == $value){
        //                     $flag = true;
        //                     $pos = $key;
        //                     break;
        //                 }
        //             }
        //             if(!$flag){
        //                 $item['id'] = $value;
        //                 $item['values'] = array();
        //                 foreach (json_decode($product->choice_options) as $key => $choice_option) {
        //                     if($choice_option->attribute_id == $value){
        //                         $item['values'] = $choice_option->values;
        //                         break;
        //                     }
        //                 }
        //                 array_push($attributes, $item);
        //             }
        //             else {
        //                 foreach (json_decode($product->choice_options) as $key => $choice_option) {
        //                     if($choice_option->attribute_id == $value){
        //                         foreach ($choice_option->values as $key => $value) {
        //                             if(!in_array($value, $attributes[$pos]['values'])){
        //                                 array_push($attributes[$pos]['values'], $value);
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // $selected_attributes = array();
        // foreach ($attributes as $key => $attribute) {
        //     $attr = Attribute::find($attribute['id']);
        //     if ($attr != null)
        //     {
        //         $attributes[$key]['attr'] = $attr;
        //     }else{
        //         unset($attributes[$key]);
        //     }
        // }

        // foreach ($attributes as $key => $attribute) {
        //     if ($request->has('attribute_'.$attribute['id'])) {
        //         foreach ($request['attribute_'.$attribute['id']] as $key => $value) {
        //             $str = '"'.$value.'"';
        //             $products = $products->where('choice_options', 'like', '%'.$str.'%');
        //         }

        //         $item['id'] = $attribute['id'];
        //         $item['values'] = $request['attribute_'.$attribute['id']];
        //         $item['attr'] = $attr;
        //         array_push($selected_attributes, $item);
        //     }
        // }


        // //Color Filter
        // $all_colors = array();

        // foreach ($non_paginate_products as $key => $product) {
        //     if ($product->colors != null) {
        //         foreach (json_decode($product->colors) as $key => $color) {
        //             if(!in_array($color, $all_colors)){
        //                 array_push($all_colors, $color);
        //             }
        //         }
        //     }
        // }

        // $selected_color = null;

        // if($request->has('color')){
        //     $str = '"'.$request->color.'"';
        //     $products = $products->where('colors', 'like', '%'.$str.'%');
        //     $selected_color = $request->color;
        // }


        // $products = filter_products($products)->paginate(12)->appends(request()->query());

        // return response()->json([
        //     'products' => new ProductCollection($products),
        //     'attributes' => $attributes
        // ], 200);


        $product_conditions['where'][] = ['published', 1];
        $product_conditions[] = 'random';
        //Filtering by brand slug
        if ($brand_id != null) {
            if ($brand = Brand::where('id', $brand_id)->firstOrFail()) {
                $element_conditions['where'][] = ['brand_id', $brand->id];
            }
        }else if($request->brand != null){
            if ($brand = Brand::where('slug', $request->brand)->firstOrFail()) {
                $element_conditions['where'][] = ['brand_id', $brand->id];
            }
        }

        if ($category_id != null) {
            if ($categoryA = Category::where('id', $category_id)->firstOrFail()) {
                $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
                $element_conditions['whereIn'][] = ['category_id' => $category_ids];
            }
        }

        if ($seller_id != null) {
            if ($seller = Seller::findOrFail($seller_id)->user) {
                $product_conditions['where'][] = ['user_id', $seller->id];
            }
        }

        //Order by sorting type
        if ($sort_by != null) {
            switch ($sort_by) {
                case 'newest':
                    $product_conditions['orderBy'][] = ['created_at' => 'desc'];
                    break;
                case 'oldest':
                    $product_conditions['orderBy'][] = ['created_at' => 'asc'];
                    break;
                case 'price-asc':
                    $product_conditions['orderBy'][] = ['price' => 'asc'];
                    break;
                case 'price-desc':
                    $product_conditions['orderBy'][] = ['price' => 'desc'];
                    break;
                default:
                    // code...
                    break;
            }
        }

        // //Новинки
        // if ($request->has('new') && $request->new) {
        //     $product_conditions['where'][] = ['todays_deal', 1];
        // }
        // //Популярные
        // if ($request->has('popular') && $request->popular) {
        //     $product_conditions['where'][] = ['featured', 1];
        // }
        // //Рекомендуемые
        // if ($request->has('recommendation') && $request->recommendation) {
        //     $product_conditions['where'][] = ['seller_featured', 1];
        // }
        // //Акции
        // if ($request->has('stock') && $request->stock) {
        //     $product_conditions['where'][] = ['discount', '>', 0];
        // }
        // //Бесплатная доставка
        // if ($request->has('freeDelevery') && $request->freeDelevery) {
        //     $product_conditions['where'][] = ['delivery_type', 'free'];
        // }
        // //Доступно в рассрочку
        // if ($request->has('installment') && $request->installment) {
        //     $product_conditions['where'][] = ['delivery_type', 'free'];
        // }
        if($query != null){
            $searchController = new SearchController;
            $searchController->store($request);
            $product_conditions['where'][] = ['name', 'like', '%'.$query.'%'];
            // $products = $products->where('name', 'like', '%'.$query.'%');//->orWhere('tags', 'like', '%'.$query.'%');
        }
        // if($query != null){
        //     $searchController = new SearchController;
        //     $searchController->store($request);
        //     $products = $products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
        // }
        $products = Product::where('element_id', '<>', null);
        $products = filterProductByRelation($products, 'product', $product_conditions);
        $products = filterProductByRelation($products, 'element', $element_conditions);
        $min_price = $request->min_price??0;
        $max_price = $request->max_price??0;
        if($min_price!=0){
            $product_conditions['where'][] = ['price', '>=', $min_price];
        }
        if($max_price!=0){
            $product_conditions['where'][] = ['price', '<=', $max_price];
        }
        foreach ($products as $product) {
            $unit_price = homeDiscountedBasePrice($product->id);
            if ($min_price > $unit_price) {
                $min_price = $unit_price;
            }
            if ($max_price < $unit_price) {
                $max_price = $unit_price;
            }
        }
        // $all_colors=$products->pluck('color_id');
        $products = filter_products($products)->paginate(12)->appends(request()->query());
        return response()->json([
            'products' => new ProductCollection($products),
            'attributes' => [],//$attributes,
            // 'colors'=>new ProductColorCollection($all_colors),
            'min_price' => $min_price ?? null,
            'max_price' => $max_price ?? null,
            'type' => $type ?? null
        ]);
    }
}
