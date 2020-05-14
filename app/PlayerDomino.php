<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerDomino extends Model
{
    protected $guarded = [];

    public function player()
    {
        return $this->hasOne('App\Player');
    }
}
