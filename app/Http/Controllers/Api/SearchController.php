<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
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

        $keywords = array();
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

        return response()->json([
            'error' => "ERROR"
        ], 500);
    }
}
