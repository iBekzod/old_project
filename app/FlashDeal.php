<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use Cviebrock\EloquentSluggable\Sluggable;

class FlashDeal extends Model
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
        $lang = $lang == false ? App::getLocale() : $lang;
        $flash_deal_translation = $this->hasMany(FlashDealTranslation::class)->where('lang', $lang)->first();
        return $flash_deal_translation != null ? $flash_deal_translation->$field : $this->$field;
    }

    public function flash_deal_translations(){
      return $this->hasMany(FlashDealTranslation::class);
    }

    public function flash_deal_products()
    {
        return $this->hasMany(FlashDealProduct::class);
    }
}
