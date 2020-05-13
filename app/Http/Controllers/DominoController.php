<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

class DominoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('domino', [
            'player_names' => $request->session()->get('player_names')
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

        Player::create([
            'user_id' => $request->user()->id,
            'name' => $request->get('name'),
        ]);

        $request->session()->put('name', $request->get('name'));

        return response()->json(['success' => 'ok', 200]);
    }
}
