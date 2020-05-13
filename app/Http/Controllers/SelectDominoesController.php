<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class SelectDominoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('/select-dominoes', [
            'name' => $request->session()->get('name')
        ]);
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
            'name' => 'required',
        ]);

        $player = Player::where([
            ['user_id', $request->user()->id],
            ['name', $request->get('name')]
        ])->first();

        $player->dominoes = $request->get('dominoes');
        $player->save();

        return response()->json(['success' => 'ok', 200]);
    }
}
