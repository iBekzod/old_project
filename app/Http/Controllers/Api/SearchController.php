<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\HelperTrait;
use App\Models\FlashDealProduct;
use App\Product;
use App\Shop;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function ajax_search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $keywords = [];
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%'))->get()->take(3);

        $categories = Category::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        if(sizeof($keywords)>0 || sizeof($categories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return response()->json([
                'products' => $products,
                'categories' => $categories,
                'keywords' => $keywords,
                'shops' => $shops,
            ]);
        }

        return response()->json((object)[], 200);
    }

    public function searchByHashtags(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'search' => 'required'
        ]);

        $keywords = [];

        $products = Product::where('published', 1)
            ->where('tags', 'like', '%'.$request->search.'%')
            ->where('category_id', $request->get('category_id'))
            ->get();

        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $category = Category::where('id', $request->get('category_id'))->with('childrenCategories')->first();

        if (!$category) {
            return response()->json([
                'desc' => 'Category not found'
            ], 404);
        }

        $category_ids = [];
        $category_ids[] = $category->id;

        foreach ($category->childrenCategories as $subcategory)
        {
            array_push($category_ids, $subcategory->id);
            if($subcategory->childrenCategories)
            {
                $this->cycleCategories($subcategory, $category_ids);
            }
        }

        $products = filter_products(Product::where('published', 1)
            ->where('name', 'like', '%' . $request->search . '%'))
            ->where('category_id', $request->get('category_id'))
            ->where(function ($query) use ($category_ids) {
                foreach ($category_ids as $category_id)
                {
                    $query->orWhere('category_id', $category_id);
                }
            })
            ->get()
            ->take(3);

        $categories = Category::where('name', 'like', '%'.$request->search.'%')
            ->get()
            ->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())
            ->where('name', 'like', '%'.$request->search.'%')
            ->get()
            ->take(3);

        if(
            sizeof($keywords)>0 ||
            sizeof($categories)>0 ||
            sizeof($products)>0 ||
            sizeof($shops) >0
        ){
            return response()->json([
                'products' => $products,
                'categories' => $categories,
                'keywords' => $keywords,
                'shops' => $shops,
            ]);
        }

        return response()->json([], 200);
    }

    public function cycleCategories($category, &$arr)
    {
        if($category->childrenCategories)
        {;
            foreach ($category->childrenCategories as $subcategory)
            {
                array_push($arr, $subcategory->id);
                $this->cycleCategories($subcategory, $arr);
            }
        }
    }
}
