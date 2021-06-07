<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = [
        'name',
        'lowest_price_id',
        'slug',
        'element_id',
        'prices',
        'variant',
        'partnum',
        'color_id',
        'photos',
        'characteristics',
        'user_id',
        'num_of_sale',
        'qty',
        'rating',
        'created_at',
        'updated_at',
    ];

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
        $variation_translations = $this->variation_translations()->where('lang', $lang)->first();
        return $variation_translations != null ? $variation_translations->$field : $this->$field;
    }

     public function variation_translations()
     {
         return $this->hasMany(VariationTranslation::class);
     }

     public function element()
     {
         return $this->hasOne(Element::class, 'id', 'element_id');
     }

    public function product()
    {
        return $this->hasOne(Product::class, 'id','lowest_price_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function delete()
    {
        $this->products()->delete();
        $this->variation_translations()->delete();
        return parent::delete();
    }
}
