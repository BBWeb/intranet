<?php

use \TestGuy;

class ManageStaffCest {

  public function updatePersonal(TestGuy $I)
  {
    Auth::loginUsingId(1);

    $I->wantTo('update the personal info for a member of the staff');

    $I->amOnPage('/staff/2/edit/personal');
    $I->seeCurrentUrlEquals('/staff/2/edit/personal');

    $I->fillField('ssn', '123456'); 
    $I->fillField('address', 'Street'); 
    $I->fillField('postal_code', '41676'); 
    $I->fillField('city', 'Gothenburg');
    $I->fillField('tel', '123123');

    $I->click('Spara personuppgifter');

    $I->seeRecord('staff_personal_data', [ 
      'user_id' => 2,
      'ssn' => '123456',
      'address' => 'Street',
      'postal_code' => '41676',
      'city' => 'Gothenburg',
      'tel' => '123123'
    ]);

    $I->seeCurrentUrlEquals('/staff/2/edit/personal');
  }

  public function setNewActivePaymentData(TestGuy $I)
  {
    // send ajax call to a route
    $I->sendAjaxPostRequest('/staff/2/edit/payment', [
      'hourly_salary' => 200,
      'income_tax' => 31.42,
      'employer_fee' => 10.5,
      'start_date' => date('Y-m-d')
    ]);

    $I->amOnPage('/staff/2/edit/payment');

    $I->seeInField('#current-hourly-salary', '200');
    $I->seeInField('#current-income-tax', '31.42');
    $I->seeInField('#current-employer-fee', '10.5');
    $I->seeInField('#current-start-date', date('Y-m-d'));
  }

}