<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayedAttrToSubreports extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('subreports', function(Blueprint $table) {
      $table->boolean('payed')->default(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('subreports', function(Blueprint $table) {
      $table->dropColumn('payed');
    });
  }

}
