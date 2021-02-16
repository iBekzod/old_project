<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeCharacteristicTranslation extends Model
{
    protected $table = 'product_attribute_characteristics_language';

    protected $fillable = [
        'lang', 'attribute_id'
    ];
}
