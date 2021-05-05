<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App;
class Variation extends Model
{
    protected $fillable = [
        'name',
        'lowest_price_id',
        'slug',
        'element_id',
        'prices',
        'variant',
        'sku',
        'user_id',
        'num_of_sale',
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
        $lang = $lang == false ? App::getLocale() : $lang;
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
}
