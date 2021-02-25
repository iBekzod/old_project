<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return response()->json([
            'featuredProduct_id' => FlashDeal::where('status','1')->where('featured','1')->with([
                'flashDealProducts' => function($query) {
                    $query->latest()->limit(12);
                }
            ])->get()
        ]);
    }
}
