<?php

namespace App\Http\Controllers\Api;

use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayersCollection;

class PlayersByLoggedInUserController extends Controller
{
    /**
     * Players index method.
     *
     * @param Request $request
     * @return PlayersCollection
     */
    public function index(Request $request)
    {
        return new PlayersCollection(
            Player::where('user_id', $request->user()->id)
                ->with('dominoes')->get()
        );
    }
}
