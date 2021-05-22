<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SubCategory
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class SubCategory extends Model
{

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}
