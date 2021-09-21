<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\ReviewCollection;
use App\Review;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class ReviewController extends Controller
{
    public function index($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->orderBy('updated_at', 'desc')->paginate(10));
    }

    public function userReview()
    {
        return new ReviewCollection(Review::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->paginate(20));
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

        $product = Product::where('id', $request->get('product_id'))->with('reviews')->get();
        $product = new ProductDetailCollection($product);

        return response()->json([
            'comment' => $comment,
            'product' => $product
        ], 200);
    }


    public function submit(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
            'rating' => 'required'
        ]);
        $product = Product::find($request->product_id);
        // $user = User::find($request->user_id);

        /*
         @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                            @if($orderDetail->order != null && $orderDetail->order->user_id == Auth::user()->id && $orderDetail->delivery_status == 'delivered' && \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                                @php
                                                    $commentable = true;
                                                @endphp
                                            @endif
                                        @endforeach
        */

        // $reviewable = false;
        // if(Auth::check()){
        //     $reviewable = true;
        // }
        // foreach ($product->orderDetails as $key => $orderDetail) {
        //     if($orderDetail->order != null && $orderDetail->order->user_id == $request->user_id && $orderDetail->delivery_status == 'delivered' && \App\Review::where('user_id', $request->user_id)->where('product_id', $product->id)->first() == null){
        //         $reviewable = true;
        //     }
        // }

        // if(!$reviewable){
        //     return response()->json([
        //         'result' => false,
        //         'message' => 'You cannot review this product'
        //     ]);
        // }

        $review = new \App\Review;
        $review->product_id = $product->product_id;
        $review->user_id = $request->user_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->viewed = 0;
        if($review->save()){
            $count = Review::where('product_id', $product->id)->where('status', 1)->count();
            if($count > 0){
                $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating')/$count;
            }
            else {
                $product->rating = 0;
            }
            $product->save();
        }

        return response()->json([
            'result' => true,
            'message' => 'Review  Submitted'
        ]);
    }
}
