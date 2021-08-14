<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CartCollection;
use App\Cart;
use App\Color;
use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        return new CartCollection(Cart::where('user_id', auth()->id())->latest()->get());
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $tax=taxPrice($product->id);
        $price = $product->price+((double)$tax)+discountPrice($product->id);
        $address=getUserAddress();
        $quantity=0;
        $shipping_cost=[];
        $shipping_cost = calculateDeliveryCost($product, $address->id, $product->delivery_type);
        $delivery_cost= $shipping_cost['total_cost'];
        $is_express=false;
        if($request->has('is_express') && $request->is_express==1){
            $is_express=true;
            $delivery_cost= $shipping_cost['total_express_cost'];
        }
        if($request->has('quantity')){
            $quantity=(double)$request->quantity;
        }else{
            $quantity=1;
        }

        Cart::updateOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->id
        ], [
            'price' => $price,
            'tax' => (double)$tax,
            'shipping_cost' =>$delivery_cost,
            'variation'=>$is_express,
            'quantity' => $quantity
        ]);

        return response()->json([
            'message' => translate('Product added to cart successfully')
        ]);
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart != null) {
            if ($cart->product->qty >= $request->quantity) {
                $cart->update([
                    'quantity' => $request->quantity
                ]);

                return response()->json(['message' => translate('Cart updated')], 200);
            }
            else {
                return response()->json(['message' => translate('Maximum available quantity reached')], 200);
            }
        }

        return response()->json(['message' => translate('Something went wrong')], 404);
    }

    public function destroy($id)
    {
        if(Cart::destroy($id))
            return response()->json(['message' => translate('Product is successfully removed from your cart')], 200);
        else
            return response()->json(['message' => translate('Cart was not found')], 404);
    }
}
