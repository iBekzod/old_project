<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Language extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $language_translations = $this->language_translations()->where('lang', $lang)->first();
        return $language_translations != null ? $language_translations->$field : $this->$field;
    }

    public function language_translations()
    {
        return $this->hasMany(LanguageTranslation::class);
    }
}
