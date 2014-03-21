<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$userNiklas = new User();
		$userNiklas->email = 'niklas@bbweb.se';
		$userNiklas->name = 'Niklas Andréasson';
		$userNiklas->password = 'niklas123';
		$userNiklas->password_confirmation = 'niklas123';
		$userNiklas->admin = true;
		$userNiklas->save();

		// User::create( array( 'name' => 'Niklas Andréasson', 'email' => 'niklas@bbweb.se', 'password' => Hash::make('niklas123'), 'admin' => true ) );

		// User::create( array( 'name' => 'Carl-Johan Blomqvist', 'email' => 'calle@bbweb.se', 'password' => Hash::make('calle123'), 'admin' => true ) );

		// User::create( array( 'name' => 'Fredrik Ghofran', 'email' => 'fredrik@bbweb.se', 'password' => Hash::make('fredrik123'), 'admin' => true ) );
	}
}
