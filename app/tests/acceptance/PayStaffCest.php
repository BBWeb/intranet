<?php
use \WebGuy;

class PayStaffCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests
    public function loginAndPayStaff(WebGuy $I) {
    	$I->am('Admin');
   		$I->wantTo('login to password-protected area'); 
   		$I->lookForwardTo('accessing password-protected area');

   		$I->amOnPage('login');
   		$I->seeCurrentUrlEquals('/login');

   		$I->fillField('email', 'niklas@bbweb.se');
   		$I->fillField('password', 'niklas123');
   		$I->click('Sign in');

   		$I->seeCurrentUrlEquals('');

      $I->click('Obetalt');
      $I->seeCurrentUrlEquals('/staff-report');

      $I->fillField('from', '10-06-2014');
      $I->fillField('to', '19-06-2014');
      $I->click('Sök');

      $I->seeCurrentUrlEquals('/staff-report/1/10-06-2014/19-06-2014');

      $I->see('Total tid: 31 minuter');
    }

}