<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
class Shop extends Model
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
  public function user()
  {
    return $this->belongsTo(User::class)->with(['seller']);
  }
}
