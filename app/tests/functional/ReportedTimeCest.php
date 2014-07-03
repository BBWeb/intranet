<?php

use \TestGuy;

class ReportedTimeCest {

	public function login(TestGuy $I)
	{
		$I->am('Site admin');
		$I->wantTo('login');
		$I->lookForwardTo('performing admin tasks');

		$I->amOnPage('login');
		$I->seeCurrentUrlEquals('/login');

   		$I->fillField('email', 'niklas@bbweb.se');
   		$I->fillField('password', 'niklas123');
   		$I->click('Sign in');

   		$I->seeCurrentUrlEquals('');
	}

	/**
	 * @before login
	 */
	public function checkReportedTime(TestGuy $I)
	{
		$I->click('Rapporterad tid');
		$I->amOnPage('/reported-time');

		$I->see('Obetald tid 1 timmar 6 minuter');
		$I->see('Betald tid 1 timmar 0 minuter');
	}

}