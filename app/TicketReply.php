<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{

    protected $fillable = [
        'user_id', 'ticket_id', 'reply', 'files'
    ];
    public function ticket(){
    	return $this->belongsTo(Ticket::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
