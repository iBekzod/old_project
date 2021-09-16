<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Element;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ShopCollection;
use App\Product;
use App\Shop;
use App\Seller;
use Exception;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        try{
            $shops=Shop::all()->reject(function ($shop) {
                return !$shop->user->seller->verification_status;
            });
        }catch(Exception $e){
            return $e->getMessage();
        }

        return new ShopCollection($shops);
    }

    public function info($id)
    {
        return new ShopCollection(Shop::where('id', $id)->orWhere('slug', $id)->get());
    }

    public function shopOfUser($id)
    {
        return new ShopCollection(Shop::where('user_id', $id)->get());
    }

    public function allProducts($id)
    {
        $shop = Shop::where('slug', $id)->firstOrFail();
        $products=getPublishedProducts('product', ['where' => [['user_id', $shop->user_id]]]);
        $minPrice = $products->where('price', '>=', 0)->min('price');
        $maxPrice = $products->where('price', '>=', 0)->max('price');
        return json_encode(array(
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'products' => new ProductCollection($products->latest()->paginate(10))
        ));
    }

    public function topSellingProducts($id)
    {
        $shop = Shop::where('slug', $id)->firstOrFail();

        return new ProductCollection(getPublishedProducts('product', ['where' => [['user_id', $shop->user_id]], 'orderBy' => [['num_of_sale'=>'desc']]])->limit(4)->get());
    }

    public function featuredProducts($id)
    {
        $shop = Shop::where('slug', $id)->firstOrFail();
        return new ProductCollection(getPublishedProducts('product', ['where' => [['user_id', $shop->user_id], ['featured' , 1]]])->latest()->get());
    }

    public function newProducts($id)
    {
        $shop = Shop::where('slug', $id)->firstOrFail();
        return new ProductCollection(getPublishedProducts('product', ['where' => [['user_id', $shop->user_id]], 'orderBy' => [['created_at'=>'desc']]])->limit(10)->get());
    }

    public function brands($id)
    {

        $shop = Shop::where('slug', $id)->firstOrFail();
        $product_element_ids=getPublishedProducts('product', ['where' => [['user_id', $shop->user_id]]])->pluck('element_id');
        $brand_ids=Element::whereIn('id', $product_element_ids)->pluck('brand_id');
        $brands=Brand::whereIn('id', $brand_ids)->get();
        // $product_by_brands=Product::select('brand_id')->where('user_id', $shop->user_id)->distinct()->get()->toArray();
        return response()->json([
            'brands'=> new BrandCollection($brands),
        ]);
    }
}
