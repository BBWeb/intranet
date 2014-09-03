<?php

class AsanaTaskTableSeeder extends Seeder {

  public function run()
  {
    AsanaTask::create([
      'id' => 1,
      'name' => 'Asana task 1',
      'completed' => false,
      'project_id' => 1,
      'user_id' => 1
    ]);

    AsanaTask::create([
      'id' => 2,
      'name' => 'Asana task 2',
      'completed' => false,
      'project_id' => 1,
      'user_id' => 1
    ]);

  }

}