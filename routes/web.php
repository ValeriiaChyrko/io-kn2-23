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

Route::group(['namespace' => 'Auth'], function () {
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('logout', 'LoginController@logout')->name('logout');
    });

    Route::middleware('guest:sanctum')->group(function() {
        Route::get('/login/google/redirect', 'LoginController@redirect')
            ->name('login.google.redirect');
        Route::get('/login/google/callback', 'LoginController@handleCallback')
            ->name('login.google.callback');
    });
});

Route::get('{path}', 'SpaController')->where('path', '^(?!api).*$');
