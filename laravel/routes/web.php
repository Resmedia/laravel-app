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
    Route::get('/', 'Admin\IndexController@index');
    Route::resource('/news', 'Admin\NewsController')->only('index');
    Route::get('/news/update/{id}', 'Admin\NewsController@update');
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
