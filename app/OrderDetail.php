<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderDetail
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $seller_id
 * @property int $product_id
 * @property string|null $variation
 * @property float|null $price
 * @property float $tax
 * @property float $shipping_cost
 * @property int|null $quantity
 * @property string $payment_status
 * @property string|null $delivery_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderDetail whereVariation($value)
 * @mixin \Eloquent
 */

class OrderDetail extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function refund_request()
    {
        return $this->hasOne(RefundRequest::class);
    }
}
