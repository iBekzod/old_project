<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $country_translation = $this->country_translations()->where('lang', $lang)->first();
        return $country_translation != null ? $country_translation->$field : $this->$field;
    }

    public function country_translations(){
        return $this->hasMany(CountryTranslation::class);
    }
}
