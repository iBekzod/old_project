<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Cviebrock\EloquentSluggable\Sluggable;

class Characteristic extends Model
{
    protected $table= "characteristics";
    protected $fillable = ['attribute_id', 'name', 'slug'];
    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? app()->getLocale() : $lang;
        $attribute_value_translation = $this->characteristic_translations()->where('lang', $lang)->first();
        return $attribute_value_translation != null ? $attribute_value_translation->$field : $this->$field;
    }

    public function characteristic_translations()
    {
        return $this->hasMany(CharacteristicTranslation::class, 'characteristic_id', 'id');
    }

    public function attribute()
    {
        return $this->hasOne(Attribute::class);
    }

    public function delete()
    {
        $this->characteristic_translations()->delete();
        return parent::delete();
    }
}
