<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\CartCollection;
use App\Cart;
use App\Color;
use App\Coupon;
use App\CouponUsage;
use App\Currency;
use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;
use App\Shop;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        return new CartCollection(Cart::where('user_id', auth()->id())->latest()->get());
    }

    public function addCustom(Request $request)
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
            'product_id' => $product->id
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


    public function summary($user_id, $owner_id)
    {
        $items = Cart::where('user_id', $user_id)->where('owner_id', $owner_id)->get();

        if ($items->isEmpty()) {
            return response()->json([
                'sub_total' => format_price(0.00),
                'tax' => format_price(0.00),
                'shipping_cost' => format_price(0.00),
                'discount' => format_price(0.00),
                'grand_total' => format_price(0.00),
                'grand_total_value' => 0.00,
                'coupon_code' => "",
                'coupon_applied' => false,
            ]);
        }

        $sum = 0.00;
        foreach ($items as $cartItem) {
            $item_sum = 0;
            $item_sum += ($cartItem->price + $cartItem->tax) * $cartItem->quantity;
            $item_sum += $cartItem->shipping_cost - $cartItem->discount;
            $sum +=  $item_sum  ;   //// 'grand_total' => $request->g
        }



        return response()->json([
            'sub_total' => format_price($items->sum('price')),
            'tax' => format_price($items->sum('tax')),
            'shipping_cost' => format_price($items->sum('shipping_cost')),
            'discount' => format_price($items->sum('discount')),
            'grand_total' => format_price($sum),
            'grand_total_value' => convert_price($sum),
            'coupon_code' => $items[0]->coupon_code,
            'coupon_applied' => $items[0]->coupon_applied == 1,
        ]);


    }

    public function getList($user_id)
    {
        $owner_ids = Cart::where('user_id', $user_id)->select('owner_id')->groupBy('owner_id')->pluck('owner_id')->toArray();
        $currency_symbol = currency_symbol();
        $shops = [];
        if (!empty($owner_ids)) {
            foreach ($owner_ids as $owner_id) {
                $shop = array();
                $shop_items_raw_data = Cart::where('user_id', $user_id)->where('owner_id', $owner_id)->get()->toArray();
                $shop_items_data = array();
                if (!empty($shop_items_raw_data)) {
                    foreach ($shop_items_raw_data as $shop_items_raw_data_item) {
                        $product = Product::where('id', $shop_items_raw_data_item["product_id"])->first();
                        $shop_items_data_item["id"] = intval($shop_items_raw_data_item["id"]) ;
                        $shop_items_data_item["owner_id"] =intval($shop_items_raw_data_item["owner_id"]) ;
                        $shop_items_data_item["user_id"] =intval($shop_items_raw_data_item["user_id"]) ;
                        $shop_items_data_item["product_id"] =intval($shop_items_raw_data_item["product_id"]) ;
                        $shop_items_data_item["product_name"] = $product->variation->name;
                        $shop_items_data_item["product_thumbnail_image"] = api_asset($product->variation->thumbnail_img);
                        $shop_items_data_item["variation"] = $shop_items_raw_data_item["variation"];
                        $shop_items_data_item["price"] =(double) $shop_items_raw_data_item["price"];
                        $shop_items_data_item["currency_symbol"] = $currency_symbol;
                        $shop_items_data_item["tax"] =(double) $shop_items_raw_data_item["tax"];
                        $shop_items_data_item["shipping_cost"] =(double) $shop_items_raw_data_item["shipping_cost"];
                        $shop_items_data_item["quantity"] =intval($shop_items_raw_data_item["quantity"]) ;
                        $shop_items_data_item["lower_limit"] = intval($product->qty) ;
                        $shop_items_data_item["upper_limit"] =  intval($product->qty);

                        $shop_items_data[] = $shop_items_data_item;

                    }
                }


                $shop_data = Shop::where('user_id', $owner_id)->first();
                if ($shop_data) {
                    $shop['name'] = $shop_data->name;
                    $shop['owner_id'] =(int) $owner_id;
                    $shop['cart_items'] = $shop_items_data;
                } else {
                    $shop['name'] = "Inhouse";
                    $shop['owner_id'] =(int) $owner_id;
                    $shop['cart_items'] = $shop_items_data;
                }
                $shops[] = $shop;
            }
        }

        //dd($shops);

        return response()->json($shops);
    }



    public function add(Request $request)
    {
        try{
            $product = Product::where('id',$request->id)->first();
            $tax = 0;
            $default_currency_id=29;
            if(Currency::where('code', 'UZB')->exists()){
                $default_currency_id=Currency::where('code', 'UZB')->first()->id;
            }
            $tax= taxPrice($product->id);
            $tax = convertToCurrency($tax, $product->currency_id, $default_currency_id);
            $price = convertToCurrency($product->price, $product->currency_id, $default_currency_id);
            $user_id=auth()->id();
            //discount calculation based on flash deal and regular discount
            //calculation of taxes
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            }
            elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
                $discount_applicable = true;
            }

            $discount = convertToCurrency(discountPrice($product->id), $product->currency_id, $default_currency_id);
            if ($discount_applicable) {
                $price += $discount;
            }else{
                $discount=0;
            }
            $address_id=$request->address_id??getUserAddress()->id;
            $delivery_cost=[];
            $delivery_cost = calculateDeliveryCost($product, $address_id, $product->delivery_type);
            $shipping_cost= $delivery_cost['total_cost']??0;
            $is_express=false;
            if($request->has('is_express') && $request->is_express==1){
                $is_express=true;
                $shipping_cost= $delivery_cost['total_express_cost'];
            }
            $shipping_cost = convertToCurrency($shipping_cost, $product->currency_id, $default_currency_id);
            $quantity=0;
            if($request->has('quantity')){
                $quantity=(double)$request->quantity;
            }else{
                $quantity=1;
            }
            if ($product->qty < $quantity) {
                return response()->json(['success' => false, 'message' => "Minimum {$product->qty} item(s) should be ordered"], 200);
            }

            $cart=Cart::updateOrCreate([
                'user_id' => $user_id,
                'owner_id' => $product->user_id,
                'product_id' => $request->id,
                'variation' => $is_express
            ], [
                'address_id'=>$address_id,
                'price' => $price,
                'tax' => $tax,
                'shipping_cost' => $shipping_cost,
                'shipping_type'=> $product->delivery_type,
                'quantity' => DB::raw("quantity + $quantity"),
                'discount' => $discount,
            ]);

            if($request->has('product_referral_code') && $request->product_referral_code!=null){
                $cart->product_referral_code=$request->product_referral_code;
            }

            // if(\App\Utility\NagadUtility::create_balance_reference($request->cost_matrix) == false){
            //     return response()->json(['result' => false, 'message' => 'Cost matrix error' ]);
            // }

            return response()->json([
                'cart_id'=>$cart->id,
                'success' => true,
                'message' => 'Product added to cart successfully'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getTrace()
                // 'message' => $e->getMessage()
            ]);
        }

    }

    public function process(Request $request)
    {
        $cart_ids = explode(",", $request->cart_ids);
        $cart_quantities = explode(",", $request->cart_quantities);

        if (!empty($cart_ids)) {
            $i = 0;
            foreach ($cart_ids as $cart_id) {
                $cart_item = Cart::where('id', $cart_id)->first();
                $product = Product::where('id', $cart_item->product_id)->first();

                if ($product->qty > $cart_quantities[$i]) {
                    return response()->json(['result' => false, 'message' => "Minimum {$product->qty} item(s) should be ordered for {$product->name}"], 200);
                }else{
                    $cart_item->update([
                        'quantity' => $cart_quantities[$i]
                    ]);
                }

                $i++;
            }

            return response()->json(['result' => true, 'message' => 'Cart updated'], 200);

        } else {
            return response()->json(['result' => false, 'message' => 'Cart is empty'], 200);
        }


    }

}
