<?php

namespace App\Http\Controllers;

use App\Player;
use App\PlayerDomino;
use Illuminate\Http\Request;

class SelectDominoesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('/select-dominoes', [
            'player_in_session' => $request->session()->get('player_in_session'),
            'used_dominoes' => PlayerDomino::all()->pluck('current')
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

        $player->dominoes = serialize($request->get('dominoes'));
        $player->save();

        return response()->json(['success' => 'ok', 200]);
    }
}
