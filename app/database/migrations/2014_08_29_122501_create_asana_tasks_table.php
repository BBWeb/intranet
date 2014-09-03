<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsanaTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asana_tasks', function(Blueprint $table) {
			$table->bigIncrements('id');

			$table->string('name');
			$table->boolean('completed')->default(false);

			$table->bigInteger('project_id');

			// place a index on this one?
			$table->unsignedInteger('user_id');

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
		Schema::drop('asana_tasks');
	}

}
