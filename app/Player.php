<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    public function dominoes()
    {
        return $this->hasMany('App\PlayerDomino', 'player_id', 'user_id');
    }
}
