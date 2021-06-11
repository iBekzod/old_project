<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class Color extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? app()->getLocale() : $lang;
        $color_translations = $this->color_translations()->where('lang', $lang)->first();
        return $color_translations != null ? $color_translations->$field : $this->$field;
    }

    public function color_translations()
    {
        return $this->hasMany(ColorTranslation::class, 'color_id', 'id');
    }

    public function delete()
    {
        $this->color_translations()->delete();
        return parent::delete();
    }
}
