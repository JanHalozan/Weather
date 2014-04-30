<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::update('ALTER TABLE users MODIFY password VARCHAR(255)');

        Schema::table('users', function(Blueprint $t)
        {
            $t->string('remember_token');
            $t->dateTime('updated_at');
            $t->dateTime('created_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $t)
        {
            $t->dropColumn(array('remember_token'));
        });
	}

}
