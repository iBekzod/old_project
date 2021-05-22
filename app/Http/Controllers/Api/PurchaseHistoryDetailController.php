<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PurchaseHistoryDetailCollection;
use App\OrderDetail;

class PurchaseHistoryDetailController extends Controller
{
    public function index($id)
    {
        return new PurchaseHistoryDetailCollection(OrderDetail::where('order_id', $id)->get());
    }
}
