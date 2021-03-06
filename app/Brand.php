<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Brand extends Model
{
  use Sluggable;
  public function sluggable(): array
  {
      return [
          'slug' => [
              'source' => 'name'
          ]
      ];
  }
  public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? app()->getLocale() : $lang;
      $brand_translation = $this->brand_translations()->where('lang', $lang)->first();
      return $brand_translation != null ? $brand_translation->$field : $this->$field;
  }

  public function brand_translations(){
    return $this->hasMany(BrandTranslation::class);
  }

  public function delete()
  {
      $this->brand_translations()->delete();
      return parent::delete();
  }
}
