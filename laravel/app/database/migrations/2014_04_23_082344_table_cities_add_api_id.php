<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCitiesAddApiId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add city id
        Schema::table('cities', function($table)
        {
            $table->string('api_id', 32);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        if (Schema::hasColumn('cities', 'api_id'))
        {
            Schema::table('cities', function($table)
            {
                $table->dropColumn('api_id');
            });
        }
	}

}
