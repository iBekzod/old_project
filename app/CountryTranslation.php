<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'country_id'];

  public function country(){
    return $this->belongsTo(Country::class);
  }
}
