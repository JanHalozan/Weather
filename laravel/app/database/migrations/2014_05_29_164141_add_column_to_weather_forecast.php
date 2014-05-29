<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToWeatherForecast extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add column
        Schema::table('weather_forecast', function($table)
        {
           $table->float('temperature');
           $table->integer('cloudiness');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //Remove the columns
        if (Schema::hasColumn('weather_forecast', 'temperature'))
        {
            Schema::table('weather_forecast', function($table)
            {
                $table->dropColumn('temperature');
            });
        }
        if (Schema::hasColumn('weather_forecast', 'cloudiness'))
        {
            Schema::table('weather_forecast', function($table)
            {
                $table->dropColumn('cloudiness');
            });
        }
	}

}
