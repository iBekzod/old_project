<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ColorCollection;
use App\Color;
use App\Http\Controllers\Controller;


class ColorController extends Controller
{
    public function index()
    {
        return new ColorCollection(Color::all());
    }
}
