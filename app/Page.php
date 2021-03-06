<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
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
      $page_translation = $this->page_translations()->where('lang', $lang)->first();
      return $page_translation != null ? $page_translation->$field : $this->$field;
  }

  public function page_translations(){
    return $this->hasMany(PageTranslation::class);
  }
}
