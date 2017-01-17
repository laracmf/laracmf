<?php

Route::group(['middleware' => 'auth:api'], function () {
    JsonApi::resource('users', 'Api\v1\UsersController');
});