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

    public function loginPlease(WebGuy $I)
    {
      $I->am('Admin');
      $I->wantTo('login to password-protected area'); 
      $I->lookForwardTo('accessing password-protected area');

      $I->amOnPage('login');
      $I->seeCurrentUrlEquals('/login');

      $I->fillField('email', 'niklas@bbweb.se');
      $I->fillField('password', 'niklas123');
      $I->click('Sign in');

      $I->seeCurrentUrlEquals('');
    }

    /**
     * @before loginPlease 
     */
    public function checkStaffReport1(WebGuy $I) {
      $I->click('Obetalt');
      $I->seeCurrentUrlEquals('/staff-report');

      $I->fillField('from', '10-06-2014');
      $I->fillField('to', '19-06-2014');
      $I->click('Sök');

      $I->seeCurrentUrlEquals('/staff-report/1/10-06-2014/19-06-2014');

      $I->see('Total tid: 31 minuter');
    }

    /**
     * @before loginPlease 
     */
    public function checkStaffReport2(WebGuy $I) {
      $I->click('Obetalt');
      $I->seeCurrentUrlEquals('/staff-report');

      $I->fillField('from', '01-05-2014');
      $I->fillField('to', '19-11-2014');
      $I->click('Sök');

      $I->seeCurrentUrlEquals('/staff-report/1/01-05-2014/19-11-2014');

      $I->see('Total tid: 66 minuter');
    }

}