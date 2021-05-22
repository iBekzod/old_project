<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\SubSubCategory
 *
 * @property int $id
 * @property int $sub_category_id
 * @property string $name
 * @property string $brands
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory whereBrands($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubSubCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubSubCategory extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
