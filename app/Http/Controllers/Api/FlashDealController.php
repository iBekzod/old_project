<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlashDealProductCollection;
use App\Http\Resources\ProductCollection;
use App\Models\FlashDeal;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function superDiscount()
    {
        return response()->json([
            'products'=> \App\Models\FlashDealProduct::latest()->take(12)->with('product')->get()
        ]);
    }

    public function featuredProduct()
    {
        $featuredProduct = FlashDeal::where('status','1')->where('featured','1')->with([
            'flashDealProducts' => function($query) {
                $query->latest()->limit(12);
            }
        ])->first();

        $products = new FlashDealProductCollection($featuredProduct->flashDealProducts);

        return response()->json($products);
    }

    public function discountEndDate()
    {
        return response()->json([
            'discountEndDate' => FlashDeal::where('end_date', '>', \Carbon\Carbon::now()->timestamp)->get()
        ]);
    }
}
