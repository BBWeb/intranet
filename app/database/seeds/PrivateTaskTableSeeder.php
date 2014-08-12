<?php

class PrivateTaskTableSeeder extends Seeder {

  public function run()
  {
    DB::table('private_tasks')->delete();

    PrivateTask::create([
      'name' => 'Testing',
      'time_worked' => 10,
      'user_id' => 1
    ]);

    PrivateTask::create([
      'name' => 'Whatyawant',
      'time_worked' => 20,
      'user_id' => 1
    ]);


  }

}