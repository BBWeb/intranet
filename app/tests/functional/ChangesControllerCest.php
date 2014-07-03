<?php

use \TestGuy;

class ChangesControllerCest {

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
	 * @depends login 
	 */
	public function visitChangesBase(TestGuy $I)
	{
		$I->am('Site admin');
		$I->wantTo('Get a list of tasks for a project and make changes to them');

		$I->amOnPage('/changes');
		$I->seeElement('select.form-control');
	}

	/**
	 * @depends visitChangesBase
	 */
	public function selectProjectToMakeChanges(TestGuy $I)
	{
		$I->click('Sök');	

		$I->seeCurrentUrlEquals('/changes/1');
		$I->see('Test Project');
	}

}