<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeCharacteristics extends Model
{
    protected $table = 'product_attribute_characteristics';

    protected $fillable = [
        'name'
    ];
}
