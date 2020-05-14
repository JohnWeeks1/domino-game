<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');
Route::post('/home', 'HomeController@store')
    ->name('home.store');

Route::get('/domino', 'DominoController@index')
    ->name('domino');
Route::post('/domino', 'DominoController@store')
    ->name('domino.store');

Route::get('/select-dominoes', 'SelectDominoesController@index')
    ->name('select-dominoes');
Route::post('/select-dominoes', 'SelectDominoesController@store')
    ->name('select-dominoes.store');

Route::get('/game', 'GameController@index')
    ->name('game');
