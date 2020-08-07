<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected static function boot()
    {
        parent::boot();
        // When instance called insert the company id into the Account Class
        static::creating(function ($model) {
            $model->company_id = auth()->user()->company_id;
        });
    }

    public function company()
    {
        // This Account belongs to a Single Company
        return $this->belongsTo('App\Company');
    }

    public function contact()
    {
        // This Account has many Contacts
        return $this->hasMany('App\Contact');
    }

    public function ticket()
    {
        // This Account has Many Tickets
        return $this->hasMany('App\Ticket');
    }
}
