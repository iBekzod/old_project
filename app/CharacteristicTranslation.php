<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacteristicTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'characteristic_id'];

  public function characteristic()
  {
    return $this->belongsTo(Characteristic::class);
  }

}
