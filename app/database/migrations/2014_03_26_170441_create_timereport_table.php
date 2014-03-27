<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimereportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subreports', function($table) {
			// these should create a key together?
			$table->integer('task_id');
			$table->index('task_id');
			$table->increments('id');

			$table->integer('time')->default(0);
			$table->date('reported_date');

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
		Schema::drop('subreports');
	}

}
