<?php

use \TestGuy;

class ReportTimeCest {

	public function filterProject(TestGuy $I)
	{
		Auth::loginUsingId(1);

		$I->wantTo('filter projects to time report on');

		$I->amOnPage('/?project=1');	
		$I->seeCurrentUrlEquals('/?project=1');

		$I->see('Task 1');
		$I->see('Task 2');
	}

}