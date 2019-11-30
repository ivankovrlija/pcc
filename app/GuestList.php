<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestList extends Model
{
    protected $casts = [
        'columns' => 'array',
        'filter_by' => 'array'
    ];

    protected $fillable = [
        'name', 'filter_by', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
