<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    protected $guarded = [];

    public function guests()
    {
        return $this->belongsToMany('App\Guest');
    }
}
