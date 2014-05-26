<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToWeatherExamples extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //Add column cloudiness and day
        Schema::table('weather_examples', function($table)
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
        //Remove the columns
        if (Schema::hasColumn('weather_examples', 'cloudiness'))
        {
            Schema::table('weather_examples', function($table)
            {
                $table->dropColumn('cloudiness');
            });
        }
        if (Schema::hasColumn('weather_examples', 'day'))
        {
            Schema::table('weather_examples', function($table)
            {
                $table->dropColumn('day');
            });
        }
	}

}
