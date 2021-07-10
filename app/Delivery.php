<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Delivery extends Model
{
    protected $fillable = [
        'user_id', 'distance', 'price'
    ];
    public $timestamps = false;

    protected $table="delivery_price";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
