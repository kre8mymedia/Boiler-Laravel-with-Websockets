<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function user()
    {
        // This Company has many Users
        return $this->hasMany('App\User');
    }

    public function account()
    {
        // This Company has many Accounts
        return $this->hasMany('App\Account');
    }
}
