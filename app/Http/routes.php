<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// send users to the home page
Route::get('/', ['as' => 'base', function () {
    Session::flash('', ''); // work around laravel bug if there is no session yet
    Session::reflash();

    return Redirect::to(Config::get('credentials.home'));
}]);

// send users to the posts page
if (Config::get('cms.blogging')) {
    Route::get('blog', ['as' => 'blog', function () {
        Session::flash('', ''); // work around laravel bug if there is no session yet
        Session::reflash();

        return Redirect::route('posts.index');
    }]);
}

// page routes
Route::resource('pages', 'PageController');

// blog routes
if (Config::get('cms.blogging')) {
    Route::resource('blog/posts', 'PostController');
    Route::resource('blog/posts.comments', 'CommentController');
}

// event routes
if (Config::get('cms.events')) {
    Route::resource('events', 'EventController');
}

Route::get('auth/social/{social}', [
    'as' => 'auth.social',
    'uses' => 'Auth\AuthController@redirectToProvider'
]);

Route::get('auth/social/{social}/callback', [
    'as' => 'auth.social.callback',
    'uses' => 'Auth\AuthController@handleProviderCallback'
]);

Route::get('register/{id}/complete/{code}', [
    'as' => 'register.complete',
    'uses' => 'Auth\AuthController@showCompleteRegistrationView'
]);

Route::post('register/{id}/complete/{code}', [
    'as' => 'save.register.complete',
    'uses' => 'Auth\AuthController@completeRegistration'
]);

Route::get('account/register', ['as' => 'account.register', 'uses' => 'ViewsController@getRegister']);
Route::get('account/login', ['as' => 'account.login', 'uses' => 'ViewsController@getLogin']);

Route::group(['middleware' => ['access']], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', ['as' => 'show.create.category.page', 'uses' => 'CategoryController@showCreateForm']);
            Route::post('/', ['as' => 'create.category', 'uses' => 'CategoryController@createCategory']);
            Route::get('/{id}', ['as' => 'show.edit.category.page', 'uses' => 'CategoryController@editCategoryForm']);
            Route::post('/{id}', ['as' => 'edit.category', 'uses' => 'CategoryController@editCategory']);
            Route::delete('/', ['as' => 'delete.category', 'uses' => 'CategoryController@deleteCategory']);
        });

        Route::get('search/pages', ['as' => 'pages.search', 'uses' => 'PageController@searchPages']);
        Route::get('categories', ['as' => 'show.categories', 'uses' => 'CategoryController@showCategories']);
        Route::get('search/categories', [
            'as' => 'categories.search',
            'uses' => 'CategoryController@searchCategories'
        ]);

        Route::get(
            '/environments',
            [
                'as' => 'show.environments.list',
                'uses' => 'ConfigurationController@showEnvironments'
            ]
        );

        Route::group(['prefix' => 'environment'], function () {
            Route::post('/', ['as' => 'create.environment', 'uses' => 'ConfigurationController@createEnvironment']);
            Route::get('/{name}', ['as' => 'show.edit.form', 'uses' => 'ConfigurationController@showEditForm']);
            Route::get('/', ['as' => 'show.create.form', 'uses' => 'ConfigurationController@showCreateForm']);
            Route::put('/{name}', ['as' => 'edit.environment', 'uses' => 'ConfigurationController@editEnvironment']);
            Route::delete(
                '/{name}',
                [
                    'as' => 'delete.environment',
                    'uses' => 'ConfigurationController@deleteEnvironment'
                ]
            );
        });

        Route::group(['prefix' => 'media'], function () {
            Route::post('/', ['as' => 'upload.media', 'uses' => 'MediaController@uploadMedia']);
            Route::get('/', ['as' => 'show.all.media', 'uses' => 'MediaController@showAllMedia']);
            Route::delete('/{id}', ['as' => 'delete.media', 'uses' => 'MediaController@deleteMedia']);
        });
    });
});
