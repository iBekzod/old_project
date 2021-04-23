<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeCategory extends Model
{
    protected $table = 'attribute_category';
    protected $fillable = [
        'category_id', 'attribute_id'
    ];
}
