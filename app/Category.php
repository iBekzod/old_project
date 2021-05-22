<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use Kalnoy\Nestedset\NodeTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

class Category extends Model
{
    use Sluggable , NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }
    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

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
        $category_translation = $this->category_translations()->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations(){
    	return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }
//    public function productAttributes()
//    {
//        return $this->belongsToMany(\App\Models\ProductAttribute::class,
//            'attribute_category',
//            'category_id',
//            'attribute_id'
//        )->with('attributes');
//    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }


    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}
