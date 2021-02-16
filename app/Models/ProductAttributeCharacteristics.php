<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ProductAttributeCharacteristics extends Model
{
    protected $table = 'product_attribute_characteristics';

    protected $fillable = [
        'name', 'attribute_id'
    ];


    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_translation = $this->hasMany(ProductAttributeCharacteristicTranslation::class, 'attribute_id', 'id')
            ->where('lang', $lang)
            ->first();
        return $attribute_translation != null ? $attribute_translation->{$field} : $this->{$field};
    }
}
