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
        'prefix' => 'admin',
        'as' => 'admin.'
    ], function () {
    Route::resource('/users', 'Admin\UserController');
    Route::get('/users/edit/{id}', 'Admin\UserController@edit');
    Route::get('/users/delete/{id}', 'Admin\UserController@deleteItem');
    Route::get('/users/create', 'Admin\UserController@create');
    Route::delete('/users/delete-image', 'Admin\UserController@deleteImage');
    Route::resource('/users/update', 'Admin\UserController')->only('update');

    Route::match(['post', 'get'], '/account', 'Admin\AccountController@update')->name('account');

    Route::get('/', 'Admin\IndexController@index');
    Route::resource('/news', 'Admin\NewsController');
    Route::resource('/news/store', 'Admin\NewsController');
    Route::resource('/news/update', 'Admin\NewsController')->only('update');
    Route::get('/news/delete/{id}', 'Admin\NewsController@deleteItem');
    Route::get('/news/create', 'Admin\NewsController@create');
    Route::get('/news/edit/{id}', 'Admin\NewsController@edit');
    Route::delete('/news/delete-image', 'Admin\NewsController@deleteImage');
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
