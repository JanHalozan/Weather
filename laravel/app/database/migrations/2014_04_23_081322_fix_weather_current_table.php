<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixWeatherCurrentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add column cloudiness and day
        Schema::table('weather_current', function($table)
        {
            $table->integer('cloudiness');
            $table->boolean('day');
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
        if (Schema::hasColumn('weather_current', 'cloudiness'))
        {
            Schema::table('weather_current', function($table)
            {
                $table->dropColumn('cloudiness');
            });
        }
        if (Schema::hasColumn('weather_current', 'day'))
        {
            Schema::table('weather_current', function($table)
            {
                $table->dropColumn('day');
            });
        }
	}

}
