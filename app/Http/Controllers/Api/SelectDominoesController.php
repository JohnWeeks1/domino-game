<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PlayerResource;
use App\Player;
use App\PlayerDomino;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelectDominoesController extends Controller
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
            'player_id' => 'required',
            'dominoes' => 'required',
        ]);

        foreach ($request->get('dominoes') as $domino) {
            PlayerDomino::create([
                'player_id' => $request->get('player_id'),
                'user_id' => $request->user()->id,
                'current' => $domino,
            ]);
        }

        return response()->json(['success' => 'ok', 200]);
    }
}
