<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCountryAddCountryCode extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //Add country code column
        Schema::table('countries', function($table)
        {
            $table->string('country_code', 5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Remove it
        if (Schema::hasColumn('countries', 'country_code'))
        {
            Schema::table('countries', function($table)
            {
                $table->dropColumn('country_code');
            });
        }
    }
}
