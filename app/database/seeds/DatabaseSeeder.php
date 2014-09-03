<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('ProjectTableSeeder');
		$this->call('AsanaTaskTableSeeder');
		$this->call('TaskTableSeeder');
		$this->call('StaffDataSeeder');
		$this->call('PrivateTaskTableSeeder');
	}

}
