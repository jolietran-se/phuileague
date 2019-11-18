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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// ===== Authentication 
Route::group(['middleware' => 'auth'], function () {

    /* Thông tin cá nhân */
    Route::group(['prefix' => 'tai-khoan-ca-nhan'], function () {
        Route::get('/{username}', 'UserController@detail')->name('user.detail');
        Route::post('/cap-nhat/{username}', 'UserController@update')->name('user.update');
    });
});
   