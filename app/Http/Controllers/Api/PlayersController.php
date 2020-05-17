<?php

namespace App\Http\Controllers\Api;

use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\PlayersCollection;

class PlayersController extends Controller
{
    /**
     * Players index method.
     *
     * @return PlayersCollection
     */
    public function index()
    {
        return new PlayersCollection(Player::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'player_names' => 'required',
        ]);

        foreach ($request->get('player_names') as $player) {
            Player::create([
                'user_id' => $request->user()->id,
                'name' => $player,
            ]);
        }

        return response()->json(['success' => 'ok', 200]);
    }

    /**
     * Show player by player_id.
     *
     * @param $player_id
     * @return PlayerResource
     */
    public function show($player_id)
    {
        return new PlayerResource(
            Player::where('id', $player_id)->first()
        );
    }
}
