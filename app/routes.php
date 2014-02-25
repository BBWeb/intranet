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

   Route::post('task-remove', 'TaskController@delete');

   Route::resource('task', 'TaskController');
   Route::post('task-update-time', 'TaskController@updateTime');
   Route::post('task-report', 'TaskController@report');

   Route::resource('asana', 'AsanaController');

   Route::get('/reported-time', 'ReportedTimeController@getIndex');

});

Route::group(array('before' => 'admin'), function() {
   Route::resource('staff', 'AdminManageStaffController');

   Route::resource('time', 'AdminReportedTimeController');
   Route::get("customer-report","CustomerViewController@getIndex");
});

Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

Route::get('logout', 'AuthController@getLogout');
