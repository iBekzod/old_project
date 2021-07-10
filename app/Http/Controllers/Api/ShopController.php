<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ShopCollection;
use App\Product;
use App\Shop;
use App\Seller;
use Exception;

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

        // $shop = Shop::where('slug', $id)->firstOrFail();

        // $product_by_brands=Product::select('brand_id')->where('user_id', $shop->user_id)->distinct()->get()->toArray();
        // return response()->json([
        //     'shop'=>$product_by_brands
        //     ]);
    }
}
