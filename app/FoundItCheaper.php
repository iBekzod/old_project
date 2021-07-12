<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoundItCheaper extends Model
{

    protected $fillable = [
       'user_id','email','links','price'
    ];
}
