<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Characteristic extends Model
{
    protected $table= "characteristics";
    protected $fillable = ['attribute_id', 'name', 'slug'];
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $attribute_value_translation = $this->characteristic_translations()->where('lang', $lang)->first();
        return $attribute_value_translation != null ? $attribute_value_translation->$field : $this->$field;
    }

    public function characteristic_translations()
    {
        return $this->hasMany(CharacteristicTranslation::class);
    }

    public function attribute()
    {
        return $this->hasOne(Attribute::class);
    }

}
