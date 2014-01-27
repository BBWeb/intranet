<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create( array( 'email' => 'niklas@bbweb.se', 'password' => Hash::make('niklas123'), 'admin' => true ) );

		User::create( array( 'email' => 'calle@bbweb.se', 'password' => Hash::make('calle123'), 'admin' => true ) );
	}
}