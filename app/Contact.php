<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function account()
    {
        // This Contact belongs to a Single Account
        return $this->belongsTo('App\Account');
    }

    public function ticket()
    {
        // This Contact has Many Tickets
        return $this->hasMany('App\Ticket');
    }
}
