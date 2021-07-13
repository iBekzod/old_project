<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportDescription extends Model
{

    protected $fillable = [
       'user_id','email','comment'
    ];
}


