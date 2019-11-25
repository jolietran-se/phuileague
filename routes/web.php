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

/* =====Thông tin cá nhân===== */
    Route::group(['prefix' => 'account'], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/{username}', 'UserController@detail')->name('user.detail');
            Route::post('/cap-nhat/{username}', 'UserController@update')->name('user.update');
            Route::post('/crop-avatar', 'UserController@imageCrop')->name('user.crop-avatar');

            Route::get('/{username}/tournaments', 'UserController@getTournaments')->name('user.tournaments');
            Route::get('/{username}/clubs', 'UserController@getClubs')->name('user.clubs');

        });
    });

/* =====Giải đấu===== */
    Route::group(['prefix' => 'league'], function () {
        // list tournament
        Route::get('/', 'TournamentController@index')->name('tournament.list');
        // create tournament
        Route::group(['middleware' => 'auth'], function () {
            Route::post('/crop-logo', 'TournamentController@imageCrop')->name('tournament.crop-logo');
            Route::get('/create-tournament', 'TournamentController@create')->name('tournament.create');
            Route::post('/create-tournament', 'TournamentController@store')->name('tournament.store');
        });
    });


   