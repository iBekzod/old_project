<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
class Attribute extends Model
{
    protected $table="attributes";
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
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function characteristics()
    {
        return $this->hasMany(Characteristic::class);
    }
}
