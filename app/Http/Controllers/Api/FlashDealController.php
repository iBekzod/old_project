<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlashDealProductCollection;
use App\Http\Resources\ProductCollection;
use App\Models\FlashDeal;
use Illuminate\Http\Request;

use \Cviebrock\EloquentSluggable\Services\SlugService;

class FlashDealController extends Controller
{
    public function superDiscount()
    {
        $discountProducts = \App\Models\FlashDealProduct::latest()->take(12)->with('product')->get();

        $featProds = $discountProducts->filter(function ($item) {
            if($item->product) {
                return $item;
            }
        });

        $arr = [];
        foreach ($featProds as $item) {
            $arr[] = $item;
        }

        $products = new FlashDealProductCollection($arr);

        return response()->json($products);
    }

    public function featuredProduct()
    {
        $featuredProduct = FlashDeal::where('status','1')->where('featured','1')->with([
            'flashDealProducts' => function($query) {
                $query->latest()->limit(12);
            }
        ])->first();

        $featProds = $featuredProduct->flashDealProducts->filter(function ($item) {
            if($item->product) {
                return $item;
            }
        });

        $arr = [];
        foreach ($featProds as $item) {
            $arr[] = $item;
        }

        $products = new FlashDealProductCollection($arr);

        return response()->json($products);
    }

    public function discountEndDate()
    {
        return response()->json([
            'discountEndDate' => FlashDeal::where('end_date', '>', \Carbon\Carbon::now()->timestamp)->get()
        ]);
    }
}
