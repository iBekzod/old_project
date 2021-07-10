<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Seller;
use App\Shop;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function shopAllProducts($id)
    {

        $shop = Shop::where('id', $id)->with('user')->firstOrFail();
        $allProducts = new ProductCollection(getPublishedProducts('product', ['where' => [['user_id', $shop->user_id]]])->paginate(24));
        // $allProducts = \App\Product::where('user_id', $shop->user_id)
        //     ->where('published', 1)
        //     ->paginate(24);

        return response()->json([
            'shop' => $shop,
            'all_products' => $allProducts,
        ], 200);
    }

    public function shopTopSelling($id)
    {
        $shop = Shop::where('id', $id)->with('user')->firstOrFail();
        $topSelling = new ProductCollection(getPublishedProducts('product', ['orderBy' => [['num_of_sale' => 'desc']],'where' => [['user_id', $shop->user_id]]])->paginate(24));
        // $topSelling = \App\Product::where('user_id', $shop->user_id)
        //     ->where('published', 1)
        //     ->orderBy('num_of_sale', 'desc')
        //     ->paginate(24);

        return response()->json([
            'shop' => $shop,
            'top_selling' => $topSelling,
        ], 200);
    }

    public function shopFeaturedProducts($id)
    {
        $shop = Shop::where('id', $id)->with('user')->firstOrFail();
        $featuredProducts = new ProductCollection(getPublishedProducts('product', ['orderBy' => [['created_at', 'desc']],'where' => [['user_id', $shop->user_id],['seller_featured', 1]]])->paginate(24));
        // $featuredProducts = \App\Product::where('user_id', $shop->user_id)
        //     ->where('published', 1)
        //     ->orderBy('created_at', 'desc'  )
        //     ->paginate(24);

        return response()->json([
            'shop' => $shop,
            'featured_products' => $featuredProducts,
        ], 200);
    }

    public function shop($id)
    {
        $shop = Shop::where('id', $id)->with('user')->firstOrFail();

        return response()->json([
            'shop' => $shop
        ], 200);
    }

    public function sellers()
    {
        return response()->json([
            'sellers' => Seller::with('user')->get(),
        ], 200);
    }

    public function seller($id)
    {
        $seller = Seller::where('id', $id)->with(['products'])->firstOrFail();

        return response()->json([
            'seller' => $seller
        ], 200);
    }

    public function topSelling($id)
    {
        $seller = Seller::findOrFail($id);
        $products = new ProductCollection(getPublishedProducts('product', ['orderBy' => [['num_of_sale', 'desc']],'where' => [['user_id', $seller->user_id]]])->paginate(24));
        // $products = \App\Product::where('user_id', $seller->user_id)
        //     ->where('published', 1)
        //     ->orderBy('num_of_sale', 'desc')
        //     ->paginate(24);

        return response()->json([
            'products' => $products
        ], 200);
    }

    public function featuredProducts($id)
    {
        $seller = Seller::findOrFail($id);
        $products = new ProductCollection(getPublishedProducts('product', ['orderBy' => [['created_at', 'desc']],'where' => [['user_id', $seller->user_id]]])->paginate(24));
        // $products = \App\Product::where('user_id', $seller->user_id)
        //     ->where('published', 1)
        //     ->orderBy('created_at', 'desc'  )
        //     ->paginate(24);

        return response()->json([
            'products' => $products
        ], 200);
    }

    public function allProducts($id)
    {
        $seller = Seller::findOrFail($id);
        $products = new ProductCollection(getPublishedProducts('product', ['where' => [['user_id', $seller->user_id]]])->paginate(24));
        // $products = \App\Product::where('user_id', $seller->user_id)
        //     ->where('published', 1)
        //     ->paginate(24);

        return response()->json([
            'products' => $products
        ], 200);
    }
}
