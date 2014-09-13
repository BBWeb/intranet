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

		$task = Task::create(array(
			'user_id' => $user->id,
			'asana_task_id' => 1
		));

		$this->createSubreport($task, 'Cool name', 31, '2014-06-11');
		// create an already payed subreport
		$this->createSubreport($task, 'Programmed', 60, '2014-06-05', true);

		$this->createSubreport($task, 'Stuff', 10, '2014-07-14');
	}

	private function createSubreport($task, $name, $time, $date, $payed = false)
	{
		Subreport::create(array(
			'task_id' => $task->id,
			'name' => $name,
			'time' => $time,
			'reported_date' => $date,
			'payed' => $payed
			)
		);
	}
}
