<?php

namespace App\Http\Controllers\Api;

use App\PlayerDomino;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DominoesIndexResource;

class DominoesController extends Controller
{
    public function index(Request $request)
    {
        return new DominoesIndexResource(
            PlayerDomino::where('user_id', $request->user()->id)->pluck('current')
        );
    }
}
