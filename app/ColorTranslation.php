<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'color_id'];

  public function color()
  {
    return $this->belongsTo(Color::class);
  }

}
