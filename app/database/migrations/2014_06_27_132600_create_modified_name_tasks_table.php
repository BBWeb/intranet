<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifiedNameTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modified_name_tasks', function(Blueprint $table)
		{
			$table->increments('id');

			$table->bigInteger('asana_task_id');
			$table->index('asana_task_id');

			$table->string('modified_title');

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
		Schema::drop('modified_name_tasks');
	}

}
