<?php

namespace App\Http\Controllers;

use App\Player;
use App\PlayerDomino;
use Illuminate\Http\Request;

class DominoController extends Controller
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
        $players = Player::where('user_id', $request->user()->id)->get();

        return view('domino', [
            'players' => $players
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
            'id' => 'required',
        ]);

        $allPlayers = PlayerDomino::where('player_id', $request->get('id'))->pluck('current');

        $player = Player::find($request->get('id'));

        $request->session()->put('player_in_session', $player);

        return response()->json(['success' => 'ok', 200]);
    }
}
