<?php

class TaskTableSeeder extends Seeder {

	public function run()
	{
		DB::table('tasks')->delete();

      // find niklas
		$user = DB::table('users')->where('email', 'niklas@bbweb.se')->first();

		// add a task
		$task = Task::create(array(
			'user_id' => $user->id,
			'asana_id' => '1',
			'project_id' => 1,
			'task' => 'Task 1'
		));

		// date
		$dateTimestamp = mktime(0, 0, 0, 6, 11, 2014);
		$date = date('Y-m-d', $dateTimestamp);	

		$subreport = Subreport::create(array(
			'task_id' => $task->id,
			'time' => 31,
			'reported_date' => $date
			)
		); 

	}
}
