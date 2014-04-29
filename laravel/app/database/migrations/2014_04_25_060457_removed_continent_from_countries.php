<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovedContinentFromCountries extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// drop column continent from countries
		Schema::table('countries', function($table)
		{
			$table->dropColumn('continent');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('countries', 'continent'))
        {
            Schema::table('countries', function($table)
            {
                $table->dropColumn('continent');
            });
        }
	}

}
