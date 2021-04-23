<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementTranslation extends Model
{
    protected $fillable = ['element_id','name', 'lang'];

    public function element(){
      return $this->belongsTo(Element::class);
    }
}
