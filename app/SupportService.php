<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportService extends Model
{

    protected $fillable = [
       'user_id','name','phone','email','message'
    ];
}
