<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $guest_id
 * @property string|null $shipping_address
 * @property string|null $payment_type
 * @property string|null $payment_status
 * @property string|null $payment_details
 * @property float|null $grand_total
 * @property float $coupon_discount
 * @property string|null $code
 * @property int $date
 * @property int $viewed
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCouponDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereGuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereViewed($value)
 * @mixin \Eloquent
 */

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function refund_requests()
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }
}
