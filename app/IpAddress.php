<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class IpAddress extends Model
{
    protected $table="ip_addresses";
    protected $fillable = [
        'ip', 'city_id', 'region_id', 'language_id', 'data'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->whereIn('type', ['district', 'city']);
    }

    public function region()
    {
        return $this->belongsTo(City::class, 'region_id')->whereIn('type', ['region']);
    }
}
