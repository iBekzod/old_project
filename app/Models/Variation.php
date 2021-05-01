<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App;

class Variation extends Model
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
    protected $fillable = [
        'name',
        'lowest_price_id',
        'slug',
        'element_id',
        'prices',
        'variant',
        'sku',
        'created_at',
        'updated_at',
    ];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;

        $variation_translations = $this->variation_translations()->where('lang', $lang)->get();

        if ((int)$variation_translations->count()) {
            return isset($variation_translations[0]) ? $variation_translations[0]->{$field} : $this->{$field};
        } else {
            return $this->{$field};
        }
    }
    public function variation_translations()
    {
        return $this->hasMany(VariationTranslation::class, 'variation_id', 'id');
    }
    public function element()
    {
        return $this->belongsTo(Element::class);
    }


}
