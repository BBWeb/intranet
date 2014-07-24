<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffCompanyDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staff_company_data', function(Blueprint $table)
		{
			$table->increments('id');

			$table->unsignedInteger('user_id');

			$table->foreign('user_id')
			->references('id')->on('users')
			->onDelete('cascade');

			$table->string('employment_nr');					
			$table->string('clearing_nr');					
			$table->string('bank');					
			$table->string('bank_nr');					

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
		Schema::drop('staff_company_data');
	}

}
