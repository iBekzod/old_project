<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Category extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_translation = $this->hasMany(CategoryTranslation::class)->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations(){
    	return $this->hasMany(CategoryTranslation::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parentCategoryHierarchy()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')->with('parentCategoryHierarchy');
    }

    public function productAttributes()
    {
        return $this->belongsToMany(\App\Models\ProductAttribute::class,
            'product_attribute_category',
            'category_id',
            'product_attribute_id'
        );
    }
}
