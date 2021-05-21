<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\VariationCollection;
use App\Variation;

class AttributeController extends Controller
{
    public function index()
    {

        return new VariationCollection(Variation::all());
    }
}
