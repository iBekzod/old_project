<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CurrencyCollection;
use App\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return new CurrencyCollection(Currency::all());
    }
}
