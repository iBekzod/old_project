<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $attributes = ['verification_info'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id');
    }

    public function getVerificationInfoAttribute($value)
    {
        return $this->attributes['verification_info']=json_decode($value, true);
    }
}
