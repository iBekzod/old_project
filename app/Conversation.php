<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['sender_id',];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'receiver_id');
    }


    // public function delete()
    // {
    //     $this->delete();
    //     return parent::delete();
    // }
}
