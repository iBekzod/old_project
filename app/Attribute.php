<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Attribute extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_translation = $this->attribute_translations()->where('lang', $lang)->first();
        return $attribute_translation != null ? $attribute_translation->$field : $this->$field;
    }

    public function attribute_translations()
    {
        return $this->hasMany(AttributeTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class);
    }
}
