<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\SearchController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategorySubCategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SearchProductCollection;
use App\Models\Attribute;
use App\Models\Category;
use App\Category as MainCategory;
use App\Models\Product;
use App\Seller;
use App\Utility\CategoryUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $category = Category::where('parent_id', $id)
            ->with('products')
            ->get();

        $category_collection = new CategoryCollection($category);
        $category_collection->additional['filter'] = $this->searchByAttrs($request, $id);
        $category_collection->additional['category'] = Category::where('id', $id)->with('parent')->first();
        $category_collection->additional['category']['tag'] = $this->getTags($category);
        $category_collection->additional['category']['brands'] = $this->getBrands($category);
        $category_collection->additional['category']['min_price'] = filter_products(\App\Product::query())->get()->min('unit_price');
        $category_collection->additional['category']['max_price'] = filter_products(\App\Product::query())->get()->max('unit_price');
        $category_collection->additional['category']->banner = api_asset($category_collection->additional['category']->banner);

        return $category_collection;
    }

    public function subCategories($id)
    {
        $category = MainCategory::where('parent_id', $id)
            ->with('products')
            ->get();

        $category_collection = new CategorySubCategoryCollection($category);

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
            $data = $item->brand;
            $brands[] = $data;
        }

        return $brands;
    }

    public function searchByAttrs($request, $id)
    {
        $category = \App\Category::where('id', $id)->first();

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

        $conditions = ['published' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if($seller_id != null){
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = \App\Product::where($conditions);

        if($category_id != null){
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products = $products->whereIn('category_id', $category_ids);
        }

        if($min_price != null && $max_price != null){
            $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if($query != null){
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
        }

        if($sort_by != null){
            switch ($sort_by) {
                case 'newest':
                    $products->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $products->orderBy('created_at', 'asc');
                    break;
                case 'price-asc':
                    $products->orderBy('unit_price', 'asc');
                    break;
                case 'price-desc':
                    $products->orderBy('unit_price', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }


        $non_paginate_products = filter_products($products)->get();

        //Attribute Filter

        $attributes = array();
        foreach ($non_paginate_products as $key => $product) {
            if($product->attributes != null && is_array(json_decode($product->attributes))){
                foreach (json_decode($product->attributes) as $key => $value) {
                    $flag = false;
                    $pos = 0;
                    foreach ($attributes as $key => $attribute) {
                        if($attribute['id'] == $value){
                            $flag = true;
                            $pos = $key;
                            break;
                        }
                    }
                    if(!$flag){
                        $item['id'] = $value;
                        $item['values'] = array();
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if($choice_option->attribute_id == $value){
                                $item['values'] = $choice_option->values;
                                break;
                            }
                        }
                        array_push($attributes, $item);
                    }
                    else {
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if($choice_option->attribute_id == $value){
                                foreach ($choice_option->values as $key => $value) {
                                    if(!in_array($value, $attributes[$pos]['values'])){
                                        array_push($attributes[$pos]['values'], $value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $selected_attributes = array();
        foreach ($attributes as $key => $attribute) {
            $attr = Attribute::find($attribute['id']);
            if ($attr != null)
            {
                $attributes[$key]['attr'] = $attr;
            }else{
                unset($attributes[$key]);
            }
        }

        foreach ($attributes as $key => $attribute) {
            if ($request->has('attribute_'.$attribute['id'])) {
                foreach ($request['attribute_'.$attribute['id']] as $key => $value) {
                    $str = '"'.$value.'"';
                    $products = $products->where('choice_options', 'like', '%'.$str.'%');
                }

                $item['id'] = $attribute['id'];
                $item['values'] = $request['attribute_'.$attribute['id']];
                $item['attr'] = $attr;
                array_push($selected_attributes, $item);
            }
        }


        //Color Filter
        $all_colors = array();

        foreach ($non_paginate_products as $key => $product) {
            if ($product->colors != null) {
                foreach (json_decode($product->colors) as $key => $color) {
                    if(!in_array($color, $all_colors)){
                        array_push($all_colors, $color);
                    }
                }
            }
        }

        $selected_color = null;

        if($request->has('color')){
            $str = '"'.$request->color.'"';
            $products = $products->where('colors', 'like', '%'.$str.'%');
            $selected_color = $request->color;
        }


        $products = filter_products($products)->paginate(12)->appends(request()->query());

        return response()->json([
            'products' => new ProductCollection($products),
            'attributes' => $attributes
        ], 200);
    }
}
