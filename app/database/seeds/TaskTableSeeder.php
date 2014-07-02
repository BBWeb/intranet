<?php

class TaskTableSeeder extends Seeder {

	public function run()
	{
		DB::table('tasks')->delete();

    	 // find niklas
		$user = DB::table('users')->where('email', 'niklas@bbweb.se')->first();

		// ADD some tasks for Niklas under different projects
		// NOTE that these are used in acceptance testing 
		// Total time for these should equal 66 minutes

		// Test project
		$task = Task::create(array(
			'user_id' => $user->id,
			'asana_id' => '1',
			'project_id' => 1,
			'task' => 'Task 1'
		));

		$this->createSubreport($task, 31, '2014-06-11');
		// create an already payed subreport
		$this->createSubreport($task, 60, '2014-06-05', true);

		$this->createSubreport($task, 10, '2014-07-14');

		// add another task to Test project for Niklas
		$task2 = Task::create(array(
			'user_id' => $user->id,
			'asana_id' => '2',
			'project_id' => 1,
			'task' => 'Task 2'
		));

		$this->createSubreport($task2, 25, '2014-05-01');
	}

	private function createSubreport($task, $time, $date, $payed = false)
	{
		Subreport::create(array(
			'task_id' => $task->id,
			'time' => $time,
			'reported_date' => $date,
			'payed' => $payed
			)
		);	
	}
}
