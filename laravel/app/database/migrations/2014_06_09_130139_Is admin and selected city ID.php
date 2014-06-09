<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IsAdminAndSelectedCityID extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $t)
        {
            $t->boolean('is_admin');
            $t->integer('city_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('users', 'is_admin'))
        {
            Schema::table('users', function($table)
            {
                $table->dropColumn('is_admin');
                $table->dropColumn('city_id');
            });
        }
	}

}
