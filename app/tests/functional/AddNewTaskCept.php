<?php

$I = new TestGuy($scenario);

$I->am('Site user');
$I->wantTo('add a new task');

$I->amOnPage('login');
$I->seeCurrentUrlEquals('/login');

$I->fillField('email', 'niklas@bbweb.se');
$I->fillField('password', 'niklas123');
$I->click('Sign in');

$I->seeCurrentUrlEquals('');

$params = array(
	'asana_id' => 102, 
	'name' => 'Testing testing', 
	'project_name' => 'Test project',
	'project_id' => 1
);

$I->sendAjaxPostRequest('/task/create', $params);

// see in db and such
$I->seeRecord('tasks', array(
	'task' => $params['name'], 
	'asana_id' => $params['asana_id'],
	'project_id' => $params['project_id']
	)
);

$I->seeRecord('projects', array(
	'id' => $params['project_id'],
	'name' => $params['project_name']
	)
);

?>