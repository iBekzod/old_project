<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Frontend extends Model
{
    protected $fillable = [ 'name', 'type'];
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ?  app()->getLocale() : $lang;
        $frontend_translation = $this->frontend_translations()->where('lang', $lang)->first();
        return $frontend_translation != null ? $frontend_translation->$field : $this->$field;
    }

    public function frontend_translations()
    {
        return $this->hasMany(FrontendTranslation::class);
    }

    public function delete()
    {
        $this->frontend_translations()->delete();
        return parent::delete();
    }
}
