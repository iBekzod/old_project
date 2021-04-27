<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class AttributeValue extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_value_translation = $this->attribute_value_translations()->where('lang', $lang)->first();
        return $attribute_value_translation != null ? $attribute_value_translation->$field : $this->$field;
    }

    public function attribute_value_translations()
    {
        return $this->hasMany(AttributeValueTranslation::class);
    }


}
