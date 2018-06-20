<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('rooms', 'RoomController@all');
Route::get('rooms/{room}', 'RoomController@one');
Route::post('rooms', 'RoomController@create');
Route::put('rooms/{room}', 'RoomController@update');
Route::delete('rooms/{room}', 'RoomController@delete');