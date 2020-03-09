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

Route::get('/', 'MainController@index');
Auth::routes();
Route::group(
    [
        'namespace' => 'Admin',
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth', 'rules']
    ], function () {
    Route::get('/', 'IndexController@index');

    Route::match(['post', 'get'], '/account', 'AccountController@update')->name('account');

    Route::resource('/users', 'UserController');
    Route::get('/users/{id}/delete', 'UserController@delete');
    Route::delete('/users/delete-image', 'UserController@deleteImage');

    Route::resource('/news', 'NewsController');
    Route::get('/news/{id}/delete', 'NewsController@delete');
    Route::delete('/news/delete-image', 'NewsController@deleteImage');
});

Route::group(
    [
        'prefix' => 'news',
        'as' => 'news.'
    ], function () {
    Route::resource('/', 'NewsController')->only('index');
    Route::get('/category/{id}', 'NewsController@index');
    Route::get('/{id}', 'NewsController@show');
});
