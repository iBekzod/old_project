<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlashDealProductCollection;
use App\Http\Resources\ProductCollection;
use App\FlashDeal;
use App\FlashDealProduct;
use Illuminate\Http\Request;

use \Cviebrock\EloquentSluggable\Services\SlugService;

class FlashDealController extends Controller
{
    public function superDiscount()
    {
        $discountProducts = FlashDealProduct::latest()->take(12)->with('product')->get();

        $featProds = $discountProducts->filter(function ($item) {
            if($item->product) {
                return $item;
            }
        });
        return response()->json(new FlashDealProductCollection($featProds));
    }

    public function featuredProduct()
    {
        $featuredProduct = FlashDeal::where('status','1')->where('featured','1')->with([
            'flashDealProducts' => function($query) {
                $query->latest()->limit(12);
            }
        ])->first();
        if($featuredProduct==null){
            return null;
        }
        $featProds = $featuredProduct->flashDealProducts->filter(function ($item) {
            if($item->product) {
                return $item;
            }
        });
        return response()->json(new FlashDealProductCollection($featProds));

    }

    public function discountEndDate()
    {
        return response()->json([
            'discountEndDate' => FlashDeal::where('end_date', '>', \Carbon\Carbon::now()->timestamp)->get()
        ]);
    }
}
