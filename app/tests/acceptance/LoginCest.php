<?php
use \WebGuy;

class LoginCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests
    public function loginWithProperCredentials(WebGuy $I) {
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

}