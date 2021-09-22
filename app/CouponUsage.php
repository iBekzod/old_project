<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $fillable = [
        'user_id', 'coupon_id'
    ];
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
