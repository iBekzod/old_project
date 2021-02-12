<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Resources\OrderCollection;
use App\PickupPoint;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\BusinessSetting;
use App\User;
use DB;

class OrderController extends Controller
{
    public function userOrders(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $orders = Order::where('user_id', $request->user_id)->get();

        return response()->json([
            'orders' => new OrderCollection($orders)
        ], 200);
    }

    public function processOrder(Request $request)
    {
        $shippingAddress = json_decode($request->shipping_address);

        $cartItems = Cart::where('user_id', $request->user_id)->get();

        $shipping = 0;
        $admin_products = array();
        $seller_products = array();
        //

        if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
            $shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
        } elseif (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
            foreach ($cartItems as $cartItem) {
                $product = \App\Product::find($cartItem->product_id);
                if ($product->added_by == 'admin') {
                    array_push($admin_products, $cartItem->product_id);
                } else {
                    $product_ids = array();
                    if (array_key_exists($product->user_id, $seller_products)) {
                        $product_ids = $seller_products[$product->user_id];
                    }
                    array_push($product_ids, $cartItem->product_id);
                    $seller_products[$product->user_id] = $product_ids;
                }
            }
            if (!empty($admin_products)) {
                    $shipping = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value;
                }
            if (!empty($seller_products)) {
                    foreach ($seller_products as $key => $seller_product) {
                        $shipping += \App\Shop::where('user_id', $key)->first()->shipping_cost;
                    }
                }
        }

        // create an order
        $order = Order::create([
            'user_id' => $request->user_id,
            'shipping_address' => json_encode($shippingAddress),
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'grand_total' => $request->grand_total + $shipping,    //// 'grand_total' => $request->grand_total + $shipping,
            'coupon_discount' => $request->coupon_discount,
            'code' => date('Ymd-his'),
            'date' => strtotime('now')
        ]);

        foreach ($cartItems as $cartItem) {
            $product = Product::findOrFail($cartItem->product_id);
            if ($cartItem->variation) {
                $cartItemVariation = $cartItem->variation;
                $product_stocks = $product->stocks->where('variant', $cartItem->variation)->first();
                $product_stocks->qty -= $cartItem->quantity;
                $product_stocks->save();
            } else {
                $product->update([
                    'current_stock' => DB::raw('current_stock - ' . $cartItem->quantity)
                ]);
            }

            $order_detail_shipping_cost = 0;

            if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
                $order_detail_shipping_cost = $shipping / count($cartItems);
            } elseif (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
                if ($product->added_by == 'admin') {
                    $order_detail_shipping_cost = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value / count($admin_products);
                } else {
                    $order_detail_shipping_cost = \App\Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
            }
            } else {
                $order_detail_shipping_cost = $product->shipping_cost;
            }

            // save order details
            OrderDetail::create([
                'order_id' => $order->id,
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'variation' => $cartItem->variation,
                'price' => $cartItem->price * $cartItem->quantity,
                'tax' => $cartItem->tax * $cartItem->quantity,
                'shipping_cost' => $order_detail_shipping_cost,
                'quantity' => $cartItem->quantity,
                'payment_status' => $request->payment_status
            ]);
            $product->update([
                'num_of_sale' => DB::raw('num_of_sale + ' . $cartItem->quantity)
            ]);
        }
        // apply coupon usage
        if ($request->coupon_code != '') {
            CouponUsage::create([
                'user_id' => $request->user_id,
                'coupon_id' => Coupon::where('code', $request->coupon_code)->first()->id
            ]);
        }
        // calculate commission
        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
        foreach ($order->orderDetails as $orderDetail) {
            if ($orderDetail->product->user->user_type == 'seller') {
                $seller = $orderDetail->product->user->seller;
                $price = $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                $seller->admin_to_pay = ($request->payment_type == 'cash_on_delivery') ? $seller->admin_to_pay - ($price * $commission_percentage) / 100 : $seller->admin_to_pay + ($price * (100 - $commission_percentage)) / 100;
                $seller->save();
            }
        }
        // clear user's cart
        $user = User::findOrFail($request->user_id);
        $user->carts()->delete();

        return response()->json([
            'success' => true,
            'message' => translate('Your order has been placed successfully')
        ]);
    }

    public function store(Request $request)
    {
        return $this->processOrder($request);
    }

    public function storeApi(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'payment_type' => 'required',
            'shipping_address' => 'required',
            'payment_status' => 'required',
            'coupon_code' => 'nullable'
        ]);
    }

    public function getUserAddress(Request $request)
    {
        if ($request->user('api')) {
            return response()->json([
                'addresses' => $request->user('api')->addresses
            ], 200);
        }

        return abort(401);
    }

    public function deleteUserAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required'
        ]);

        $address = Address::findOrFail($request->address_id);
        $address->delete();

        return response([],200);
    }

    public function storeUserAddress(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'set_default' => 'required|integer'
        ]);

        if ($request->user('api')) {
            $user = $request->user('api');

            Address::create([
                'user_id' => $user->id,
                'address' => $request->get('address'),
                'country' => $request->get('country'),
                'city' => $request->get('city'),
                'postal_code' => $request->get('postal_code'),
                'phone' => $request->get('phone'),
                'set_default' => $request->get('set_default')
            ]);

            $addresses = $user->addresses;

            return response()->json([
                'addresses' => $addresses
            ], 200);
        }

        return abort(401);
    }

    public function getPickUpPoints(Request $request)
    {
        return response()->json([
            'pick_up_points' => \App\PickupPoint::where('pick_up_status', 1)->get()
        ], 200);
    }

    public function paymentMethods()
    {
        return response()->json([
            'methods' => [
                [
                    'name' => 'cash_on_delivery',
                    'image' => static_asset('assets/img/cards/cod.png'),
                    'type' => 1
                ],
            ]
        ]);
    }

    public function processApiCheckout(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'address_id'         => 'required',
            'cart_products'      => 'required',
            'payment_type'       => 'required',
            'shipping_type'      => 'required'
        ]);
        $user = User::where('id', $request->user_id)->first();
        $address = Address::where('id', $request->address_id)->first();

        $obj = new \stdClass();
        $obj->name = $user->name;
        $obj->email = $user->email;
        $obj->address = $address->address;
        $obj->country = $address->country;
        $obj->city = $address->city;
        $obj->postal_code = $address->postal_code;
        $obj->phone = $address->phone;
        $obj->checkout_type = $address->checkout_type;

        $shippingAddress = $obj;
        $cartItems = $request->cart_products;
        $shipping = 0;
        $admin_products = array();
        $seller_products = array();
        $grand_price = 0;

        foreach ($cartItems as $item) {
            $grand_price += $item['price'];
            $shipping += $item['shipping'];
        }

        if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
            $shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
        } elseif (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
            foreach ($cartItems as $cartItem) {
                $product = \App\Product::find($cartItem['id']);
                if ($product->added_by == 'admin') {
                    array_push($admin_products, $cartItem['id']);
                } else {
                    $product_ids = array();
                    if (array_key_exists($product->user_id, $seller_products)) {
                        $product_ids = $seller_products[$product->user_id];
                    }
                    array_push($product_ids, $cartItem['id']);
                    $seller_products[$product->user_id] = $product_ids;
                }
            }
            if (!empty($admin_products)) {
                $shipping = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value;
            }
            if (!empty($seller_products)) {
                foreach ($seller_products as $key => $seller_product) {
                    $shipping += \App\Shop::where('user_id', $key)->first()->shipping_cost;
                }
            }
        }

        switch ($request->payment_type) {
            case 1:
                $payment_type = 'cash_on_delivery';
                break;
            default:
                $payment_type = 'cash_on_delivery';
                break;
        }

        $payment_status = 'unpaid';

        // create an order
        $order = Order::create([
            'user_id' => $request->user_id,
            'shipping_address' => json_encode($shippingAddress),
            'payment_type' => $payment_type,
            'payment_status' => $payment_status,
            'grand_total' => $grand_price + $shipping,    //// 'grand_total' => $request->grand_total + $shipping,
//            'coupon_discount' => $request->coupon_discount,
            'code' => date('Ymd-his'),
            'date' => strtotime('now')
        ]);

        foreach ($cartItems as $cartItem) {
            $product = Product::findOrFail($cartItem['id']);
            if ($cartItem['variation']) {
                $cartItemVariation = $cartItem['variation'];
                $product_stocks = $product->stocks->where('variant', $cartItem['variation'])->first();
                $product_stocks->qty -= $cartItem['quantity'];
                $product_stocks->save();
            } else {
                $product->update([
                    'current_stock' => DB::raw('current_stock - ' . $cartItem['quantity'])
                ]);
            }

            $order_detail_shipping_cost = 0;

            if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
                $order_detail_shipping_cost = $shipping / count($cartItems);
            } elseif (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
                if ($product->added_by == 'admin') {
                    $order_detail_shipping_cost = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value / count($admin_products);
                } else {
                    $order_detail_shipping_cost = \App\Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
                }
            } else {
                $order_detail_shipping_cost = $product->shipping_cost;
            }

            // save order details
            OrderDetail::create([
                'order_id' => $order->id,
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'variation' => $cartItem['variation'],
                'price' => $cartItem['price'] * $cartItem['quantity'],
                'tax' => $cartItem['tax'] * $cartItem['quantity'],
                'shipping_cost' => $order_detail_shipping_cost,
                'quantity' => $cartItem['quantity'],
                'payment_status' => $payment_status
            ]);
            $product->update([
                'num_of_sale' => DB::raw('num_of_sale + ' . $cartItem['quantity'])
            ]);
        }

        // apply coupon usage
//        if ($request->coupon_code != '') {
//            CouponUsage::create([
//                'user_id' => $request->user_id,
//                'coupon_id' => Coupon::where('code', $request->coupon_code)->first()->id
//            ]);
//        }

        // calculate commission
        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
        foreach ($order->orderDetails as $orderDetail)
        {
            if ($orderDetail->product->user->user_type == 'seller') {
                $seller = $orderDetail->product->user->seller;
                $price = $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                $seller->admin_to_pay = ($request->payment_type == 'cash_on_delivery') ? $seller->admin_to_pay - ($price * $commission_percentage) / 100 : $seller->admin_to_pay + ($price * (100 - $commission_percentage)) / 100;
                $seller->save();
            }
        }

        // clear user's cart
//        $user = User::findOrFail($request->user_id);
//        $user->carts()->delete();

        return response()->json([
            'success' => true,
            'message' => translate('Your order has been placed successfully')
        ]);
    }
}
