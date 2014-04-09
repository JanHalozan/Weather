<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTest extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test', function(Blueprint $t)
		{
			//create test table
			$t->increments('id');
			$t->string('test_text');
			$t->boolean('working')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	   	Schema::drop('test');
	}

}