<?php

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'ApiAuth\LoginController@login');
    Route::post('register', 'ApiAuth\RegisterController@register');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {

        // Authentication Routes...
        Route::get('logout', 'ApiAuth\LoginController@logout');

        Route::post('password/reset', 'ApiAuth\ResetPasswordController@reset');
        Route::post('password/forgot', 'ApiAuth\ForgotPasswordController@sendResetLinkEmail');

        Route::get('/test', function () {
            return response()->json(['message' => 'authenticated']);
        });
    });
});
