<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class CharacteristicTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'characteristic_id'];

  public function characteristic()
  {
    return $this->belongsTo(Characteristic::class);
  }

}
