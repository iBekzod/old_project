<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Resources\OrderCollection;
use App\PickupPoint;
use Illuminate\Http\Request;
use App\Order;
use App\Cart;
use App\Product;
use App\OrderDetail;
use App\Coupon;
use App\CouponUsage;
use App\BusinessSetting;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentMethod;

class OrderController extends Controller
{

    // public function store(Request $request, $set_paid = false)
    // {
    //     $cartItems = Cart::where('user_id', $request->user_id)->where('owner_id', $request->owner_id)->get();

    //     if ($cartItems->isEmpty()) {
    //         return response()->json([
    //             'order_id' => 0,
    //             'result' => false,
    //             'message' => 'Cart is Empty'
    //         ]);
    //     }

    //     $user = User::find($request->user_id);

    //     $address = Address::where('id', $cartItems->first()->address_id)->first();
    //     $shippingAddress = [];
    //     if ($address != null) {
    //         $shippingAddress['name']        = $user->name;
    //         $shippingAddress['email']       = $user->email;
    //         $shippingAddress['address']     = $address->address;
    //         $shippingAddress['country']     = $address->country;
    //         $shippingAddress['city']        = $address->city;
    //         $shippingAddress['postal_code'] = $address->postal_code;
    //         $shippingAddress['phone']       = $address->phone;
    //         if($address->latitude || $address->longitude) {
    //             $shippingAddress['lat_lang'] = $address->latitude.','.$address->longitude;
    //         }
    //     }

    //     $sum = 0.00;
    //     foreach ($cartItems as $cartItem) {
    //         $item_sum = 0;
    //         $item_sum += ($cartItem->price + $cartItem->tax) * $cartItem->quantity;
    //         $item_sum += $cartItem->shipping_cost - $cartItem->discount;
    //         $sum += $item_sum;   //// 'grand_total' => $request->g
    //     }


    //     // create an order
    //     $order = Order::create([
    //         'user_id' => $request->user_id,
    //         'seller_id' =>$request->owner_id,
    //         'shipping_address' => json_encode($shippingAddress),
    //         'payment_type' => $request->payment_type,
    //         'payment_status' => $set_paid ? 'paid' : 'unpaid',
    //         'grand_total' => $sum,
    //         'coupon_discount' => $cartItems->sum('discount'),
    //         'code' => date('Ymd-his'),
    //         'date' => strtotime('now')
    //     ]);

    //     foreach ($cartItems as $cartItem) {
    //         $product = Product::find($cartItem->product_id);

    //         $product_stocks = $product->stocks->where('variant', $cartItem->variation)->first();
    //         $product_stocks->qty -= $cartItem->quantity;
    //         $product_stocks->save();

    //         /*if ($cartItem->variation) {
    //             $product_stocks = $product->stocks->where('variant', $cartItem->variation)->first();
    //             $product_stocks->qty -= $cartItem->quantity;
    //             $product_stocks->save();
    //         } else {
    //             $product->update([
    //                 'current_stock' => DB::raw('current_stock - ' . $cartItem->quantity)
    //             ]);
    //         }*/

    //         // save order details
    //         OrderDetail::create([
    //             'order_id' => $order->id,
    //             'seller_id' => $product->user_id,
    //             'product_id' => $product->id,
    //             'variation' => $cartItem->variation,
    //             'price' => $cartItem->price * $cartItem->quantity,
    //             'tax' => $cartItem->tax * $cartItem->quantity,
    //             'shipping_cost' => $cartItem->shipping_cost,
    //             'quantity' => $cartItem->quantity,
    //             'payment_status' => $set_paid ? 'paid' : 'unpaid'
    //         ]);
    //         $product->update([
    //             'num_of_sale' => DB::raw('num_of_sale + ' . $cartItem->quantity)
    //         ]);
    //     }
    //     // apply coupon usage

    //     if ($cartItems->first()->coupon_code != '') {
    //         CouponUsage::create([
    //             'user_id' => $request->user_id,
    //             'coupon_id' => Coupon::where('code', $cartItems->first()->coupon_code)->first()->id
    //         ]);
    //     }

    //     Cart::where('user_id', $request->user_id)->where('owner_id', $request->owner_id)->delete();

    //     return response()->json([
    //         'order_id' => $order->id,
    //         'result' => true,
    //         'message' => translate('Your order has been placed successfully')
    //     ]);
    // }

    public function userOrders(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id'
        // ]);

        $orders = Order::where('user_id', auth()->id())->get();

        return response()->json([
            'orders' => new OrderCollection($orders)
        ], 200);
    }

    public function processOrder(Request $request)
    {
        try{
            $request->validate([
                'shipping_address' => 'required',
                // 'user_id' => 'required',
                'payment_type' => 'required',
                'payment_status' => 'required',
                'grand_total' => 'required',
                'coupon_discount' => 'required',
                'coupon_code' => 'required',
            ]);

            $user_id=auth()->id();//??$request->user_id;
            $shippingAddress = $request->shipping_address;//json_decode($request->shipping_address);

            $cartItems = Cart::where('user_id', $user_id)->get();

            $shipping = 0;
            $seller_products = array();
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                // $product_ids = array();
                $seller_products[$product->user_id][]=$product->id;
                // if (array_key_exists($product->user_id, $seller_products)) {
                //     $product_ids = $seller_products[$product->user_id];
                // }
                // array_push($product_ids, $cartItem->product_id);
                // $seller_products[$product->user_id] = $product_ids;
            }

            if (!empty($seller_products)) {
                foreach ($seller_products as $key => $seller_product_ids) {
                    $product=Product::where('id', $seller_product_ids[0])->first();
                    $address= getUserAddress();
                    $shipping_cost = calculateDeliveryCost($product, $address->id, $product->delivery_type);
                    $shipping += $shipping_cost['total_cost'];
                }
            }

            // create an order
            $order = Order::create([
                'user_id' => $user_id,
                'shipping_address' =>$shippingAddress,// json_encode($shippingAddress),
                'payment_type' => $request->payment_type,
                'payment_status' => $request->payment_status,
                'grand_total' => $request->grand_total + $shipping,    //// 'grand_total' => $request->grand_total + $shipping,
                'coupon_discount' => $request->coupon_discount,
                'code' => date('Ymd-his'),
                'date' => strtotime('now')
            ]);

            foreach ($cartItems as $cartItem) {
                $product=$cartItem->product;

                $product->update([
                    'num_of_sale' => DB::raw('num_of_sale - ' . $cartItem->quantity)
                ]);
                // }


                $address= getUserAddress();
                $shipping_cost = calculateDeliveryCost($product, $address->id, $product->delivery_type);
                $order_detail_shipping_cost = (double) $shipping_cost['total_cost'];
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
            // if ($request->coupon_code != '') {
            //     if(Coupon::where('code', $request->coupon_code)->first()){
            //         CouponUsage::create([
            //             'user_id' => $user_id,
            //             'coupon_id' => Coupon::where('code', $request->coupon_code)->first()->id
            //         ]);
            //     }else{
            //         return response()->json([
            //             'success' => false,
            //             'message' => "Invalid coupon code"
            //         ]);
            //     }
            // }
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
            $user = User::where('id',$user_id)->first();
            $user->carts()->delete();
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                // 'message' => $e->getTrace()
                'message' => $e->getMessage()
            ]);
        }
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

        $user = $request->user();
        $addresses = $user->addresses;

        return response()->json([
            'addresses' => $addresses
        ], 200);
    }

    public function storeUserAddress(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'region_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'set_default' => 'required|integer',
            'longitude' =>'required',
            'latitude' =>'required',
        ]);

        if ($request->user('api')) {
            $user = $request->user('api');

            Address::create([
                'user_id' => $user->id,
                'address' => $request->get('address'),
                'region_id' => $request->get('region_id'),
                'city_id' => $request->get('city_id'),
                'postal_code' => $request->get('postal_code'),
                'phone' => $request->get('phone'),
                'set_default' => $request->get('set_default'),
                'longitude' => $request->get('longitude'),
                'latitude' => $request->get('latitude'),
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
        // PaymentMethod::where()
        return response()->json([
            'methods' => [
                [
                    'name' => 'cash_on_delivery',
                    'image' => static_asset('assets/img/cards/cod.png'),
                    'type' => 1
                ]
            ]
        ]);
    }

    public function processApiCheckout(Request $request)
    {
        $request->validate([
            'user_id'            => 'required',
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
        $obj->region_id = $address->region_id;
        $obj->city_id = $address->city_id;
        $obj->postal_code = $address->postal_code;
        $obj->phone = $address->phone;
        $obj->checkout_type = $address->checkout_type;
        $obj->longitude = $address->longitude;
        $obj->latitude = $address->latitude;


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
            'coupon_discount' => $request->coupon_discount,
            'code' => date('Ymd-his'),
            'date' => strtotime('now')
        ]);

        foreach ($cartItems as $cartItem) {
            $product = Product::findOrFail($cartItem['id']);
            if ($cartItem['variation']) {
                $cartItemVariation = $cartItem['variation'];
                $product_stocks = $product->first();
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
       if ($request->coupon_code != '') {
           CouponUsage::create([
               'user_id' => $request->user_id,
               'coupon_id' => Coupon::where('code', $request->coupon_code)->first()->id
           ]);
       }

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
        //    $user = User::findOrFail($request->user_id);
        //    $user->carts()->delete();

        return response()->json([
            'success' => true,
            'message' => translate('Your order has been placed successfully')
        ]);
    }

    public function processApiCheckout_old(Request $request)
    {
        $request->validate([
            'user_id'            => 'required',
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
        $obj->region_id = $address->region_id;
        $obj->city_id = $address->city_id;
        $obj->postal_code = $address->postal_code;
        $obj->phone = $address->phone;
        $obj->checkout_type = $address->checkout_type;
        $obj->longitude = $address->longitude;
        $obj->latitude = $address->latitude;


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
            'coupon_discount' => $request->coupon_discount,
            'code' => date('Ymd-his'),
            'date' => strtotime('now')
        ]);

        foreach ($cartItems as $cartItem) {
            $product = Product::findOrFail($cartItem['id']);
            if ($cartItem['variation']) {
                $cartItemVariation = $cartItem['variation'];
                $product_stocks = $product->first();
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
       if ($request->coupon_code != '') {
           CouponUsage::create([
               'user_id' => $request->user_id,
               'coupon_id' => Coupon::where('code', $request->coupon_code)->first()->id
           ]);
       }

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
        //    $user = User::findOrFail($request->user_id);
        //    $user->carts()->delete();

        return response()->json([
            'success' => true,
            'message' => translate('Your order has been placed successfully')
        ]);
    }
}
