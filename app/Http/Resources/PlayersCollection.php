<?php

namespace App\Http\Resources;

use App\Player;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlayersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($player) {
                return [
                    'id' => $player->id,
                    'user_id' => $player->user_id,
                    'name' => $player->name,
                    'dominoes' => $player->dominoes->pluck('current')
                ];
            })
        ];
    }
}
