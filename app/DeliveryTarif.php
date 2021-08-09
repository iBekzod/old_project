<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryTarif extends Model
{
    protected $fillable = [
        'seller_region_id', 'client_region_id', 'distance'
    ];
    public $timestamps = false;

    protected $table="delivery";

    public function from_region()
    {
        return $this->belongsTo(City::class, 'seller_region_id');
    }

    public function to_region()
    {
        return $this->belongsTo(City::class, 'client_region_id');
    }
}
