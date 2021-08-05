<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryTarif extends Model
{
    protected $fillable = [
        'user_id', 'name', 'distance_price', 'days', 'weight_price', 'express_percent', 'express_hours'
    ];
    public $timestamps = false;

    protected $table="delivery_tarif";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
