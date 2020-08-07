<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body'
    ];

    public function user()
    {
        //this Comment belong to a User
        $this->belongsTo('App\User');
    }

    public function ticket()
    {
        //this Comment belong to a Ticket
        $this->belongsTo('App\Ticket');
    }
}
