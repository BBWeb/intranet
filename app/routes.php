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
   Route::controller('account', 'AccountController');
   Route::get('reported-time', 'ReportedTimeController@getIndex');

   Route::group(array('before' => 'apikey'), function() {
      Route::get('/', 'ProjectsController@getIndex');

      Route::controller('task', 'TaskController');

      Route::resource('asana', 'AsanaController');
   });
});

Route::group(array('before' => 'admin'), function() {
   Route::resource('staff', 'AdminManageStaffController');

   // Route::resource('time', 'AdminReportedTimeController');
   Route::get('staff-report','AdminReportedTimeController@getIndex');
   Route::get('staff-report/{user}', 'AdminReportedTimeController@getTimeReport');

   Route::get('staff-report/payed', 'AdminReportedTimeController@getPayedIndex');
   // Route::get('staff-report/{user}/{from}/{to}/print', 'AdminReportedTimeController@printProjectOverview');

   Route::get('customer-report','CustomerViewController@getIndex');
   Route::get('customer-report/{project}/{from}/{to}', 'CustomerViewController@getProjectOverview');
   Route::get('customer-report/{project}/{from}/{to}/print', 'CustomerViewController@printProjectOverview');
});

Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

Route::get('logout', 'AuthController@getLogout');
