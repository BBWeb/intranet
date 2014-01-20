<?php

class TaskTableSeeder extends Seeder {

	public function run()
	{
		DB::table('tasks')->delete();

      // find niklas
      $user = DB::table('users')->where('email', 'niklas@bbweb.se')->first(); 

      // create a task
      Task::create( array( 'asana_id' => 0, 'user_id' => $user->id, 'project' => 'RouteCare', 'task' => 'Fixat grafik', 'status' => 'notreported' ) );

	}
}
