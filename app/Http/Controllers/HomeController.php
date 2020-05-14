<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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
}
