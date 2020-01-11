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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/auth/redirect/{provider}', 'Auth\SocialLoginController@redirectToProvider');
Route::get('/callback/{provider}', 'Auth\SocialLoginController@handleProviderCallback');
Route::resource('user','UserController')->except(['show','create','store']);
Route::post('user/{id}/activate','UserController@activate')->name('user.activate');
Route::post('user/{id}/deactivate','UserController@deactivate')->name('user.deactivate');


Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth:customer','check-subscription']);
Route::get('payment', 'SubscribeController@payment')->middleware('auth:customer');
Route::post('subscribe', 'SubscribeController@subscribe')->middleware('auth:customer');
