<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'address', 'country', 'city', 'postal_code', 'phone', 'set_default'
    ];
}
