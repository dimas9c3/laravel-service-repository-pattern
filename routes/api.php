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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::get('/get_menu', 'MenuController@get');

    Route::prefix('todo')->group(function () {
        Route::get('/', 'TodoController@get');
        Route::post('/save', 'TodoController@store');
        Route::post('/delete', 'TodoController@destroy');
        Route::post('/update', 'TodoController@update');
    });

    Route::prefix('pasien')->group(function () {
        Route::get('/', 'TodoController@getPasien');
    });

});


