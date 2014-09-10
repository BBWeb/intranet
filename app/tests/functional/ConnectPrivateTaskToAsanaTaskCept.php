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
	'private_task_id' => 1,
	'asana_task_id' => 1,
);

$I->sendAjaxPostRequest('/task/connect-asana', $params);

// see in db and such
$task = $I->grabRecord('tasks', array(
	'user_id' => 1,
	'asana_task_id' => 1
	)
);

$I->seeRecord('subreports', array(
	'task_id' => $task->id
	)
);

?>