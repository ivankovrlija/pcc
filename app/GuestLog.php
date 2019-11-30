<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestLog extends Model
{
    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
