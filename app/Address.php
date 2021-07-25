<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Address extends Model
{

    protected $fillable = [
        'user_id', 'address', 'city_id', 'region_id', 'postal_code', 'phone', 'set_default', 'longitude', 'latitude'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->whereIn('type', ['district', 'city']);
    }

    public function region()
    {
        return $this->belongsTo(City::class, 'region_id')->whereIn('type', ['region']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
