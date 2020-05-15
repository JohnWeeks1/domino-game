<?php

namespace App\Http\Controllers\Api;

use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return new PlayersCollection(Player::with('dominoes')->get());
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
     * Show player by id.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        return response()->json([
            'player' => $player,
            'dominoes' => $player->dominoes->pluck('current')
        ]);
    }
}
