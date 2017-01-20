<?php

Route::group(['middleware' => 'auth:api', 'as' => 'api.'], function () {
    JsonApi::resource('users', 'Api\v1\UsersController');
});