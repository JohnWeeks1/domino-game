<?php

namespace App\Http\Controllers\Api;

use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelectDominoesController extends Controller
{
    /**
     * Show
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        //
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

        return response()->json(['success' => 'ok', 200]);
    }
}
