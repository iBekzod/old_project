<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryPrice extends Model
{
    protected $fillable = [
        'user_id', 'distance', 'distance_price', 'days', 'weight_price', 'express_percent', 'express_hours'
    ];
    public $timestamps = false;

    protected $table="delivery_price";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
