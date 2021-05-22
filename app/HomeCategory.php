<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\HomeCategory
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $subsubcategories
 * @property int $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory whereSubsubcategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class HomeCategory extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('activated', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
