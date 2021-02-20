<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReviewCollection;
use App\Models\Review;
use App\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
            'rating' => 'required'
        ]);

        $comment = Review::create([
            'product_id' => $request->get('product_id'),
            'user_id' => $request->get('user_id'),
            'comment' => $request->get('comment'),
            'rating' => $request->get('rating')
        ]);

        $product = Product::where('id', $request->get('product_id'))->with('reviews')->firstOrFail();

        return response()->json([
            'comment' => $comment,
            'product' => $product
        ], 200);
    }
}
