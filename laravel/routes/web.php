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
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::match(['post', 'get'], '/admin/account', 'Admin\AccountController@update')->name('account');

Route::group(
    [
        'namespace' => 'Admin',
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth', 'rules']
    ], function () {
    Route::get('/', 'IndexController@index');

    Route::get('/parser', 'ParserController@index')->name('parser');

    Route::resource('/users', 'UserController');
    Route::get('/users/{id}/delete', 'UserController@delete')->name('users.delete');
    Route::match(['post'], '/users/delete-image', 'UserController@deleteImage')->name('users.deleteImage');

    Route::resource('/news', 'NewsController');
    Route::get('/news/{id}/delete', 'NewsController@delete')->name('news.delete');
    Route::match(['post'], '/news/delete-image', 'NewsController@deleteImage')->name('news.deleteImage');
});

Route::group(
    [
        'prefix' => 'news',
        'as' => 'news.'
    ], function () {
    Route::resource('/', 'NewsController')->only('index');
    Route::get('/category/{id}', 'NewsController@index');
    Route::get('/{url}', 'NewsController@show');
});
