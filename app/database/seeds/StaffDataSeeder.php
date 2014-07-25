<?php

class StaffDataSeeder extends Seeder {

	public function run()
	{
		// old payment data
		StaffPaymentData::create([
			'user_id' => 1,
			'hourly_salary' => 150,
			'start_date' => '2014-04-15'
		]);

		// active payment data
		StaffPaymentData::create([
			'user_id' => 1,
			'hourly_salary' => 200,
			'start_date' => date('Y-m-d') 
		]);

		// future salary 
		StaffPaymentData::create([
			'user_id' => 1,
			'hourly_salary' => 250,
			'start_date' => '2016-04-16'
		]);
	}
}