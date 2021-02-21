<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicValues extends Model
{
    protected $fillable = [
        'product_id',
        'attr_id',
        'name',
        'values',
    ];
}
