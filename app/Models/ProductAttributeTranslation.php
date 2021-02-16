<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeTranslation extends Model
{
    protected $table = 'product_attributes_translation';

    protected $fillable = [
        'name', 'lang', 'attribute_id'
    ];
}
