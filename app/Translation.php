<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Translation extends Model
{
    protected $fillable = [
        'lang',
        'lang_key',
        'lang_value',
    ];
}
