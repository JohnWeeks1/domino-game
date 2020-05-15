<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:api'], function() {

    Route::get('/players', 'Api\PlayersController@index')
        ->name('players.index');

    Route::post('/players', 'Api\PlayersController@store')
        ->name('players.store');

    Route::post('/players/{id}', 'Api\PlayersController@show')
        ->name('players.show');


    Route::post('/domino', 'Api\DominoController@store')
        ->name('domino.store');

    Route::post('/select-dominoes/{id}', 'Api\SelectDominoesController@show')
        ->name('select-dominoes.show');

    Route::post('/select-dominoes', 'Api\SelectDominoesController@store')
        ->name('select-dominoes.store');
});
