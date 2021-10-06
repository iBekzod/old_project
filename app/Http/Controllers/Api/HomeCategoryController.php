<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\HomeCategoryCollection;
use App\HomeCategory;

class HomeCategoryController extends Controller
{
    public function index()
    {
        return new HomeCategoryCollection(HomeCategory::all());
    }
}
