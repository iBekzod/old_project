<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReasonTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'reason_id'];

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
}
