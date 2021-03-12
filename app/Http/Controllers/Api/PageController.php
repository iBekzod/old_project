<?php

namespace App\Http\Controllers\Api;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page(Request $request)
    {
        $request->validate([
            'type' => 'sometimes',
            'slug' => 'sometimes'
        ]);
        
        return response()->json([
            'page' => Page::where('type', $request->get('type'))->orWhere('slug', $request->get('slug'))->first()
        ]);
    }
}
