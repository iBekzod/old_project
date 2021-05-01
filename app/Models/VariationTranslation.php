<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'variation_id'];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
      }

}
