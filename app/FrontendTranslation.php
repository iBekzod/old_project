<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontendTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'frontend_id'];

    public function frontend()
    {
        return $this->belongsTo(Frontend::class);
    }
}
