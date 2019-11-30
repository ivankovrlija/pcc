<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestFolioLog extends Model
{
    public function guestfolio()
    {
        return $this->belongsTo('App\Folio');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function guests()
    {
        return $this->belongsTo('App\Guest');
    }
}
