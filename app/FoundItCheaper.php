<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoundItCheaper extends Model
{

    protected $fillable = [
       'product_id','email','links','price','currency_id'
    ];
}
