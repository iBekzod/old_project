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

    public function pages()
    {
        return response()->json([
            'page' => Page::select(['id', 'type', 'title', 'slug'])->get()
        ]);
    }

    public function footer_pages()
    {
        return response()->json([
            'footer_1' => Page::select(['id', 'type', 'title', 'slug'])->where('type', 'footer_1')->get(),
            'footer_2' => Page::select(['id', 'type', 'title', 'slug'])->where('type', 'footer_2')->get(),
            'footer_3' => Page::select(['id', 'type', 'title', 'slug'])->where('type', 'footer_3')->get()
        ]);
    }
}
