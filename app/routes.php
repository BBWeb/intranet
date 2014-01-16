<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function() {

   Route::get('/', 'ProjectsController@getIndex');

	Route::controller('account', 'AccountController');

   Route::resource('task', 'TaskController');

   Route::resource('asana', 'AsanaController');

});

Route::controller('login', 'AuthController');
