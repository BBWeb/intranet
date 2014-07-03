<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$userNiklas = new User();
		$userNiklas->email = 'niklas@bbweb.se';
		$userNiklas->name = 'Niklas Andréasson';
		$userNiklas->password = Hash::make('niklas123');
		$userNiklas->api_key = '123';
		$userNiklas->admin = true;
		$userNiklas->save();

		User::create(array(
			'email' => 'user@bbweb.se',
			'name' => 'User Doe',
			'password' => Hash::make('user123'),
			'admin' => false
			)
		);
	}
}
