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

Route::get('users', 'UserController@index');
Route::get('user/create', 'UserController@create');
Route::post('user/store', 'UserController@store');
Route::post('user/{userId}', 'UserController@update');
Route::get('user/{userId}/edit', 'UserController@edit');
Route::delete('user/{userId}', 'UserController@destroy');

Route::get('forms', 'FormController@index');
Route::get('form/create', 'FormController@create');
Route::post('form/store', 'FormController@store');
Route::post('form/{formId}', 'FormController@update');
Route::get('form/{formId}/edit', 'FormController@edit');
Route::delete('form/{formId}', 'FormController@destroy');

Route::get('orders', 'OrderController@index');
Route::get('form/{formId}/order/create', 'OrderController@create');
Route::post('form/{formId}/order/store', 'OrderController@store');
Route::post('form/{formId}/order/{orderId}', 'OrderController@update');
Route::get('form/{formId}/order/{orderId}/edit', 'OrderController@edit');
Route::delete('form/{formId}/order/{orderId}', 'OrderController@destroy');

Route::get('cap/search', 'CapController@search');
Route::get('permission', 'PermissionController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Entrust::routeNeedsRole('users', array('admin'), Redirect::to('/permission'));
//Entrust::routeNeedsPermission('users', array('create-user', 'edit-user'));
