<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffPersonalDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staff_personal_data', function(Blueprint $table)
		{
			$table->increments('id');

			$table->unsignedInteger('user_id');

			$table->foreign('user_id')
			      ->references('id')->on('users')
			      ->onDelete('cascade');

			$table->string('ssn');
			$table->string('address');
			$table->string('postal_code');
			$table->string('city');
			$table->string('tel');

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
		Schema::drop('staff_personal_data');
	}

}
