<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffPaymentDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staff_payment_data', function(Blueprint $table)
		{
			$table->increments('id');

			$table->unsignedInteger('user_id');

			$table->foreign('user_id')
			->references('id')->on('users')
			->onDelete('cascade');

			// eg 31,42 or 100 (think this is the correct way)
			$table->decimal('income_tax', 5, 2)->default(30);	
			$table->decimal('employer_fee', 5, 2)->default(31.42);
			$table->integer('hourly_salary');
			$table->date('start_date');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staff_payment_data');
	}

}
