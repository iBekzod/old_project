<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WishlistCollection;
use App\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index($id)
    {
        return new WishlistCollection(Wishlist::where('user_id', $id)->with('product')->latest()->get());
    }

    public function store(Request $request)
    {
        Wishlist::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'product_id' => $request->product_id
            ]
        );

        return response()->json([
            'message' => 'Product is successfully added to your wishlist',
            'wishlists' => new WishlistCollection(Wishlist::where('user_id', $request->user_id)->latest()->get())
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        Wishlist::destroy($id);

        return response()->json([
            'message' => 'Product is successfully removed from your wishlist',
            'wishlists' => new WishlistCollection(Wishlist::where('user_id', $request->user('api')->id)->latest()->get())
        ], 200);
    }

    public function isProductInWishlist(Request $request)
    {
        $product = Wishlist::where(['product_id' => $request->product_id, 'user_id' => $request->user_id])->count();
        if ($product > 0)
            return response()->json([
                'message' => 'Product present in wishlist',
                'is_in_wishlist' => true,
                'product_id' => (integer) $request->product_id,
                'wishlist_id' => (integer) Wishlist::where(['product_id' => $request->product_id, 'user_id' => $request->user_id])->first()->id
            ], 200);

        return response()->json([
            'message' => 'Product is not present in wishlist',
            'is_in_wishlist' => false,
            'product_id' => (integer) $request->product_id,
            'wishlist_id' => 0
        ], 200);
    }
}
