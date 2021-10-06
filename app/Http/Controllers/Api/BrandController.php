<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BrandCollection;
use App\Brand;
use App\Http\Controllers\Controller;


class BrandController extends Controller
{
    public function index()
    {
        return new BrandCollection(Brand::all());
    }

    public function top()
    {
        return new BrandCollection(Brand::where('top', 1)->get());
    }
}
