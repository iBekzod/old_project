<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Branch extends Model
{
    protected $table = 'branches';

    protected $fillable = [
        'name'
    ];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $branch_translation = $this->hasMany(BranchTranslation::class, 'attribute_id', 'id')
            ->where('lang', $lang)
            ->first();
        return $branch_translation != null ? $branch_translation->{$field} : $this->{$field};
    }

    public function branch_translations()
    {
        return $this->hasMany(BranchTranslation::class, 'branch_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,
            'attribute_category',
            'attribute_id',
            'category_id'
        );
    }
}
