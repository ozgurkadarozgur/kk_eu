<?php

Auth::routes();

Route::group(['domain' => 'admin.' . env('APP_MAIN_URL'), 'namespace' => 'Admin'], function () {

    Route::post('/reset-password/{token}', 'PlayerAccountController@reset_password')->name('api.player.reset_password');
    Route::get('/reset-password/{token}', 'PlayerAccountController@reset_password_view')->name('api.player.reset_password_view');
    Route::get('/reset-password-result/{status}', 'PlayerAccountController@reset_password_result')->name('api.player.reset_password_result');

    Route::get('login', 'AuthController@login')->name('admin.auth.login');
    Route::post('login', 'AuthController@login_attempt')->name('admin.auth.login_attempt');
    Route::post('logout', 'AuthController@logout')->name('admin.auth.logout');

    Route::get('/', 'HomeController@index')->name('admin.home');

    Route::group(['prefix' => 'facilities'], function () {
        Route::get('/', 'FacilityController@index')->name('admin.facility.index');
        Route::get('/create', 'FacilityController@create')->name('admin.facility.create');
        Route::post('/', 'FacilityController@store')->name('admin.facility.store');
        Route::get('/{id}', 'FacilityController@show')->name('admin.facility.show');
        Route::post('/{id}/store-astroturf', 'FacilityController@store_astroturf')->name('admin.facility.astroturf.store');
        Route::post('/{id}/store-user', 'FacilityController@store_user')->name('admin.facility.user.store');
    });

    Route::group(['prefix' => 'astroturf-services'], function () {
        Route::get('/', 'AstroturfServiceController@index')->name('admin.astroturf.services.index');
        Route::post('/', 'AstroturfServiceController@store')->name('admin.astroturf.services.store');
    });

    Route::group(['prefix' => 'astroturfs'], function () {
        Route::get('/', 'AstroturfController@index')->name('admin.astroturf.index');
        Route::get('/{id}', 'AstroturfController@show')->name('admin.astroturf.show');
        Route::patch('/{id}', 'AstroturfController@update')->name('admin.astroturf.update');
        Route::post('/{id}/calendar', 'AstroturfController@store_calendar')->name('admin.astroturf.calendar.store');
        Route::delete('/{id}/calendar', 'AstroturfController@destroy_calendar')->name('admin.astroturf.calendar.destroy');
        Route::delete('/{id}/subscribed-calendar', 'AstroturfController@destroy_subscribed_calendar')->name('admin.astroturf.subscribed-calendar.destroy');
        Route::post('/{id}/gallery', 'AstroturfController@store_gallery_item')->name('admin.astroturf.gallery.store');
    });

    Route::group(['prefix' => 'player-skills'], function (){
        Route::get('/', 'PlayerSkillController@index')->name('admin.player.skill.index');
        Route::post('/', 'PlayerSkillController@store')->name('admin.player.skill.store');
    });

    Route::group(['prefix' => 'players'], function (){
        Route::get('/', 'PlayerController@index')->name('admin.player.index');
        Route::get('/{id}', 'PlayerController@show')->name('admin.player.show');
    });

    Route::group(['prefix' => 'teams'], function () {
        Route::get('/', 'TeamController@index')->name('admin.team.index');
        Route::get('/{id}', 'TeamController@show')->name('admin.team.show');
    });

    Route::group(['prefix' => 'vs'], function () {
        Route::get('/', 'VSController@index')->name('admin.vs.index');
        Route::get('/{id}', 'VSController@show')->name('admin.vs.show');
    });

    /*
    Route::group(['prefix' => 'tournaments'], function () {
        Route::get('/', 'TournamentController@index');
    });
    */

    Route::group(['prefix' => 'eliminations'], function () {
        Route::get('/', 'EliminationController@index')->name('admin.elimination.index');
        Route::get('/create', 'EliminationController@create')->name('admin.elimination.create');
        Route::post('/', 'EliminationController@store')->name('admin.elimination.store');
        Route::get('/{id}', 'EliminationController@show')->name('admin.elimination.show');
        Route::get('/{id}/edit', 'EliminationController@edit')->name('admin.elimination.edit');
        Route::patch('/{id}/update', 'EliminationController@update')->name('admin.elimination.update');
        Route::delete('/{id}', 'EliminationController@destroy')->name('admin.elimination.destroy');
        Route::post('/{id}/start', 'EliminationController@start')->name('admin.elimination.start');
        Route::get('/{id}/matches', 'EliminationController@matches')->name('admin.elimination.matches');
        Route::post('/{id}/next-level', 'EliminationController@next_level')->name('admin.elimination.matches.next_level');
    });

    Route::group(['prefix' => 'elimination-matches'], function () {
        Route::patch('/{id}', 'EliminationMatchController@update_partial')->name('admin.elimination.match.update');
    });

    Route::group(['prefix' => 'leagues'], function () {
        Route::get('/', 'LeagueController@index')->name('admin.league.index');
        Route::get('/create', 'LeagueController@create')->name('admin.league.create');
        Route::post('/', 'LeagueController@store')->name('admin.league.store');
        Route::get('/{id}', 'LeagueController@show')->name('admin.league.show');
        Route::post('/{id}/start', 'LeagueController@start')->name('admin.league.start');
        Route::get('/{id}/fixture', 'LeagueController@fixture')->name('admin.league.fixture');
    });

    Route::group(['prefix' => 'league-fixtures'], function () {
        Route::patch('/{id}', 'LeagueFixtureController@update_partial')->name('admin.league.fixture.update');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@index')->name('admin.category.index');
        Route::get('/create', 'CategoryController@create')->name('admin.category.create');
        Route::post('/', 'CategoryController@store')->name('admin.category.store');
        Route::get('/{id}', 'CategoryController@show')->name('admin.category.show');
        Route::get('/{id}/edit', 'CategoryController@edit')->name('admin.category.edit');
        Route::patch('/{id}/update', 'CategoryController@update')->name('admin.category.update');
        Route::delete('/{id}', 'CategoryController@destroy')->name('admin.category.destroy');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'ProductController@index')->name('admin.product.index');
        Route::get('/create', 'ProductController@create')->name('admin.product.create');
        Route::post('/', 'ProductController@store')->name('admin.product.store');
        Route::get('/{id}', 'ProductController@show')->name('admin.product.show');
        Route::get('/{id}/edit', 'ProductController@edit')->name('admin.product.edit');
        Route::patch('/{id}/update', 'ProductController@update')->name('admin.product.update');
        Route::delete('/{id}', 'ProductController@destroy')->name('admin.product.destroy');
    });

});