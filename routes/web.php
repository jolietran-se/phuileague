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

        Route::group(['middleware' => 'auth'], function () {
            Route::post('/crop-logo', 'TournamentController@imageCrop')->name('tournament.crop-logo');
            // Tạo giải đấu
            Route::get('/create-tournament', 'TournamentController@create')->name('tournament.create');
            Route::post('/create-tournament', 'TournamentController@store')->name('tournament.store');
            
            Route::group(['prefix' => '{slug}'], function () {
                // Tùy chỉnh giải đấu
                Route::group(['prefix' => 'setting'], function () {
                    Route::get('/', 'TournamentSettingController@setting')->name('tournament.setting');                  // thông tin chung
                    Route::post('/', 'TournamentSettingController@updateSetting')->name('tournament.update');            // cập nhật thông tin chung
                    
                    Route::get('/status', 'TournamentSettingController@status')->name('setting.status');                 // trạng thái
                    Route::get('/clubs', 'TournamentSettingController@clubs')->name('setting.clubs');                    // quản lý các đội bóng
                    Route::get('/group-stage', 'TournamentSettingController@groupstage')->name('setting.groupstage');    // sắp xếp bảng đấu
                    Route::get('/match-stage', 'TournamentSettingController@matchstage')->name('setting.matchstage');    // sắp xếp cặp đấu
                    Route::get('/schedule', 'TournamentSettingController@schedule')->name('setting.schedule');           // quản lý lịch đấu
                    Route::get('/ranking-rule', 'TournamentSettingController@rankingrule')->name('setting.rankingrule'); // quy tắc xếp hạng
                    Route::get('/supporter', 'TournamentSettingController@supporter')->name('setting.supporter');        // nhà tài trợ
                    
                    Route::get('/{charter}', 'TournamentSettingController@exportChater')->name('tournament.charter');    // cập nhật thông tin chung
                    Route::post('/status/{status}', 'TournamentSettingController@updateStatus')->name('tournament.update-status');    // cập nhật thông tin chung
                });

                // Other
                Route::get('/dashboard', 'TournamentController@dashboard')->name('tournament.dashboard');           // tin chung or đăng ký thi đấu
                Route::get('/list-register', 'TournamentController@listRegister')->name('tournament.listregister'); // danh sách đăng ký
                Route::get('/stage-group', 'TournamentController@stageGroup')->name('tournament.stagegroup');       // vòng bảng
                Route::get('/knockout', 'TournamentController@knockout')->name('tournament.knockout');              // vòng loại trực tiếp
                Route::get('/ranking', 'TournamentController@ranking')->name('tournament.ranking');                 // bảng xếp hạng
                Route::get('/list-club', 'TournamentController@listClubs')->name('tournament.listclub');            // danh sách các đội tham gia
                Route::get('/statistics', 'TournamentController@statistics')->name('tournament.statistics');        // thống kê
                Route::get('/about', 'TournamentController@about')->name('tournament.about');                       // giới thiệu và điều lệ
            });

        });
    });

/* =====Đội bóng===== */
    Route::group(['prefix' => 'club'], function(){
        // list club
        Route::get('/', 'ClubController@index')->name('club.list');

        Route::group(['middleware' => ['auth']], function () {
            Route::post('/crop-logo', 'ClubController@logoCrop')->name('club.crop-logo');
            Route::post('/crop-uniform', 'ClubController@uniformCrop')->name('club.crop-uniform');
            // Tạo giải đấu
            Route::get('/create-club', 'ClubController@create')->name('club.create');
            Route::post('/create-club', 'ClubController@store')->name('club.store');
        });
        
    });

   