<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportedDateToTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
   public function up()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
         $table->date('reported_date');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
         $table->dropColumn('reported_date');
		});
	}

}
