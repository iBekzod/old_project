<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';

    protected $fillable = [
        'name'
    ];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_translation = $this->hasMany(ProductAttributeTranslation::class, 'attribute_id', 'id')
            ->where('lang', $lang)
            ->first();
        return $attribute_translation != null ? $attribute_translation->{$field} : $this->{$field};
    }

    public function attribute_translations()
    {
        return $this->hasMany(ProductAttributeTranslation::class, 'attribute_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttributeCharacteristics::class, 'attribute_id', 'id');
    }
}
