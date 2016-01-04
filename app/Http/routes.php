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

/*
Route::get('/', function () {
	if(Auth::check()) {
		return redirect('home');
	} else {
    	return view('welcome');
	}
});
*/

Route::get('/', function () {    return view('index'); });

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//Route::get('home', function () { return redirect('/'); } );
Route::get('home', 'HomeController@index' );

Route::get('tasks/admin', 'TaskController@admin' );
Route::resource('tasks', 'TaskController' );

Route::get('search', 'searchController@index');

//Route::get('administration',function () { return view('administration/index'); } );
Route::get('administration','administration@index' );

Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
	 Route::post('register', 'AuthenticateController@register');
});


