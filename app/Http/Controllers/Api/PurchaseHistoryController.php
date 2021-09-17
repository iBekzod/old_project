<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PurchaseHistoryCollection;
use App\Order;
use App\Http\Controllers\Controller;


class PurchaseHistoryController extends Controller
{
    public function index()
    {
        return new PurchaseHistoryCollection(Order::where('user_id', auth()->id())->latest()->get());
    }
}
