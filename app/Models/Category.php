<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Kalnoy\Nestedset\NodeTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $banner
 * @property string|null $icon
 * @property int $featured
 * @property int $top
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Category extends Model
{
    use NodeTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategoryHierarchy()
    {
        return $this->hasOne(\App\Category::class, 'id', 'parent_id')->with('parentCategoryHierarchy');
    }

    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
