<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'language_id'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
