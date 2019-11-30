<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $guarded = [];

    public function folios()
    {
        return $this->belongsToMany('App\Folio');
    }

    public function guest_folio()
    {
        return $this->belongsTo('App\GuestFolioLog');
    }
}
