<?php

use \WebGuy;

class UserCest
{
	public function _before()
	{

	}

	public function _after()
	{

	}

	public function loginWithProperCredentials(WebGuy $I)
	{
		$I->am('User');
		$I->wantTo('login to password-protected area');
		$I->lookForwardTo('changing my password');

		$I->amOnPage('login');
		$I->seeCurrentUrlEquals('/login');

		$I->fillField('email', 'user@bbweb.se');
		$I->fillField('password', 'user123');
		$I->click('Sign in');

	    // new users get directed to account as they don't have an api key
		$I->seeCurrentUrlEquals('/account');
	}

	/**
     * @before loginWithProperCredentials
     */
	public function changePasswordWithProperCredentials(WebGuy $I)
	{
		$I->fillField('password', '123user');
		$I->fillField('password_confirmation', '123user');
		$I->click('Uppdatera lösenord');

		$I->see('Lösenord uppdaterat!');      
	}
}

