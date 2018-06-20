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

Route::post('sign-up', 'Auth\RegisterController@register');
Route::post('sign-in', 'Auth\LoginController@login');
Route::delete('sign-out', 'Auth\LoginController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('rooms', 'RoomController@all');
    Route::get('rooms/{room}', 'RoomController@one');
    Route::post('rooms', 'RoomController@create');
    Route::put('rooms/{room}', 'RoomController@update');
    Route::delete('rooms/{room}', 'RoomController@delete');
});