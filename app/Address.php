<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Address extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id', 'address', 'country', 'city', 'postal_code', 'phone', 'set_default'
    ];
}
