<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariationTranslation extends Model
{
    protected $fillable = ['variation_id','name', 'lang'];

    public function variation(){
      return $this->belongsTo(Variation::class);
    }
}
