<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('private_tasks', function(Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('user_id');
			$table->foreign('user_id')
						->references('id')->on('users')
						->onDelete('cascade');

			$table->string('name');
			$table->integer('time_worked');

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
		Schema::drop('private_tasks');
	}

}
