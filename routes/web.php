<?php

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

Route::namespace('Ui')->group(function () {
    Route::get('/', 'TodoController@index');

    Route::prefix('todo')->group(function () {
        Route::get('/', 'TodoController@easyUiBasic')->name('todo.basic');
        Route::get('/pasien', 'TodoController@pasien');
        Route::get('/editable', 'TodoController@easyUiEditable')->name('todo.editable');
        Route::get('/logout', 'TodoController@logout')->name('todo.logout');
    });
});
