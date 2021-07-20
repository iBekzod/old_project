<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerSetting extends Model
{
    protected $table="seller_settings";
    protected $fillable = [
        'user_id', 'value', 'type', 'relation_id'
    ];
}
