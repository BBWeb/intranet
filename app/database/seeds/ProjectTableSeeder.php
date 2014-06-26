<?php

class ProjectTableSeeder extends Seeder {

	public function run()
	{
		DB::table('projects')->delete();
	
		Project::create(array(
			'id' => 1,
			'name' => 'Test project'	
			)
		);		
	}
}