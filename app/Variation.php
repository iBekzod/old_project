<?php

namespace App;

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

//    public $appends = [
//        'thumbnaile_image', 'characteristicValues2'
//    ];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;

        $product_translations = $this->product_translations()->where('lang', $lang)->get();

        if ((int)$product_translations->count()) {
            return isset($product_translations[0]) ? $product_translations[0]->{$field} : $this->{$field};
        } else {
            return $this->{$field};
        }
    }
    public function variation_translations()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
    }
    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function parentHierarchy()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->with('parentCategoryHierarchy');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getThumbnaileImageAttribute()
    {
        return api_asset($this->thumbnail_img);
    }

}
