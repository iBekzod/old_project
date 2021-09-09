<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Reason extends Model
{
    protected $fillable = [ 'name'];
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ?  app()->getLocale() : $lang;
        $reason_translation = $this->reason_translations()->where('lang', $lang)->first();
        return $reason_translation != null ? $reason_translation->$field : $this->$field;
    }

    public function reason_translations()
    {
        return $this->hasMany(ReasonTranslation::class);
    }
}
