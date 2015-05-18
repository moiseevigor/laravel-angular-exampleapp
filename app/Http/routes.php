<?php

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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('user', 'UserController@index');
Route::get('user/create', 'UserController@create');
Route::post('user/store', 'UserController@store');
Route::post('user/{userId}', 'UserController@update');
Route::get('user/{userId}/edit', 'UserController@edit');
Route::delete('user/{userId}', 'UserController@destroy');

Route::get('form', 'UserFormController@index');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
