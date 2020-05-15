<?php

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

    Route::post('/players/{player_id}', 'Api\PlayersController@show')
        ->name('players.show');

    Route::get('/dominoes', 'Api\DominoesController@index')
        ->name('dominoes.index');

    Route::post('/select-dominoes/{player_id}', 'Api\SelectDominoesController@show')
        ->name('select-dominoes.show');

    Route::post('/select-dominoes', 'Api\SelectDominoesController@store')
        ->name('select-dominoes.store');
});
