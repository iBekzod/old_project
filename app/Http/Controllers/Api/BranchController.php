<?php

namespace App\Http\Controllers\Api;

use App\Branch as AppBranch;
use App\Http\Resources\BranchCollection;
use App\Branch;
class BranchController extends Controller
{
    public function index()
    {
      //  return "hasbgfasfdhaghdf";

        return new BranchCollection(AppBranch::all());
    }
}
