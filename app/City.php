<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class City extends Model
{
    protected $fillable = [
        'country_id', 'parent_id', 'distance', 'name', 'type', 'inside_price', 'has_express', 'is_selected'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function children()
    {
        return $this->hasMany(City::class, 'parent_id');
    }

    public function parent()
    {
        if($this->parent_id==0){
            return $this->belongsTo(Country::class);
        }
        return $this->belongsTo(City::class);
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? app()->getLocale() : $lang;
        $city_translation = $this->city_translations()->where('lang', $lang)->first();
        return $city_translation != null ? $city_translation->$field : $this->$field;
    }

    public function city_translations(){
      return $this->hasMany(CityTranslation::class);
    }

    public function delete()
    {
        $this->city_translations()->delete();
        return parent::delete();
    }
}
