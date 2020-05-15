<?php

namespace App\Http\Controllers\Api;

use App\Player;
use App\PlayerDomino;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DominoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'player' => 'required',
        ]);

        $player = $request->get('player');

        $usedDominoes = PlayerDomino::where('player_id', $player['id'])->pluck('current');

        return response()->json([
            'player' => $player,
            'usedDominoes' => $usedDominoes
        ], 200);
    }
}
