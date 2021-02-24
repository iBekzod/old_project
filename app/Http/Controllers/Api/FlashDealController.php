<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function superDiscount()
    {
        return response()->json([
            'products'=> \App\Models\FlashDealProduct::latest()->take(12)->with('product')->get()
        ]);
    }
}
