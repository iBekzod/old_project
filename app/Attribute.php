<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    protected $table="attributes";
    protected $fillable = [
        'id', 'branch_id', 'name', 'combination'
    ];
    use SoftDeletes;
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ?  app()->getLocale() : $lang;
        $attribute_translation = $this->attribute_translations()->where('lang', $lang)->first();
        return $attribute_translation != null ? $attribute_translation->$field : $this->$field;
    }

    public function attribute_translations()
    {
        return $this->hasMany(AttributeTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class);
    }

    public function characteristics()
    {
        return $this->hasMany(Characteristic::class);
    }

    public function delete()
    {
        $this->characteristics()->delete();
        $this->categories()->detach();
        $this->attribute_translations()->delete();
        return parent::delete();
    }
}
