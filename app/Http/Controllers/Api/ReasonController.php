<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReasonCollection;
use App\Reason;
use App\Http\Controllers\Controller;


class ReasonController extends Controller
{
    public function index()
    {
        return new ReasonCollection(Reason::all());
    }
}
