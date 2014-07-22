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

   Route::group(array('before' => 'apikey'), function() {
      Route::get('/', 'ProjectsController@getIndex');

      Route::controller('task', 'TaskController');

      Route::resource('asana', 'AsanaController');
   });
});

Route::group(array('before' => 'auth', 'prefix' => 'reported-time'), function() {

   Route::get('/', array(
      'as' => 'reported-time.index',
      'uses' => 'ReportedTimeController@getIndex'
      )
   );
   
   Route::get('/{project}', array(
      'as' => 'reported-time.showProject',
      'uses' => 'ReportedTimeController@showProject'
      )
   );

   Route::post('/', array(
      'as' => 'reported-time.filter',
      'uses' => 'ReportedTimeController@filter'
      )
   );
});

Route::group(array('before' => 'admin'), function() {
   Route::resource('staff', 'AdminManageStaffController');

   Route::get('/staff/{id}/edit/personal', [
      'as' => 'staff.personal',
      'uses' => 'AdminManageStaffController@personal'
      ]);

   Route::get('/staff/{id}/edit/company', [
     'as' => 'staff.company',
     'uses' => 'AdminManageStaffController@company' 
      ]);

   // Route::resource('time', 'AdminReportedTimeController');
   Route::get('staff-report','AdminReportedTimeController@getIndex');

   Route::post('staff-report/filter', 'AdminReportedTimeController@filterTimeReport');
   Route::get('staff-report/{user}/{from}/{to}', array(
         'as' => 'getTimeReport',
         'uses' => 'AdminReportedTimeController@getTimeReport'
      )
   );

   Route::get('staff-report/payed', 'AdminReportedTimeController@getPayedIndex');
   Route::get('staff-report/payed/{user}', 'AdminReportedTimeController@getPayedUser');
   // Route::get('staff-report/{user}/{from}/{to}/print', 'AdminReportedTimeController@printProjectOverview');


   // CUSTOMER REPORT 
   Route::get('customer-report','CustomerViewController@getIndex');
   Route::post('customer-report/filter', 'CustomerViewController@filter');
   Route::get('customer-report/{project}/{from}/{to}', array(
         'as' => 'customer.getTimeReport',
         'uses' => 'CustomerViewController@getProjectOverview'
      )
   );

   Route::get('customer-report/{project}/{from}/{to}/print', 'CustomerViewController@printProjectOverview');

   // CHANGES
   Route::get('changes', 'ChangesController@getIndex');
   Route::post('changes', 'ChangesController@postIndex');

   Route::get('changes/{project}', array(
      'as' => 'changes.project',
      'uses' => 'ChangesController@getProject'
      )
   );

});

Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

Route::get('logout', 'AuthController@getLogout');
