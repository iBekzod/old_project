<?php

namespace App\Http\Controllers\Api;

use App\Attribute as AppAttribute;
use App\Http\Resources\AttributeCollection;
use App\Attribute;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index()
    {
      //  return "hasbgfasfdhaghdf";

        return new AttributeCollection(AppAttribute::all());
    }
}
