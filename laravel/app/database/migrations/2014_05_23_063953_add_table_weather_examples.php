<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableWeatherExamples extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weather_examples', function(Blueprint $t)
        {
            $t->bigIncrements('id');
			$t->integer('condition_id')->references('id')->on('weather_conditions');
			$t->float('temperature');
			$t->float('pressure');
			$t->integer('humidity');
			$t->integer('wind_direction');
			$t->float('wind_speed');
			$t->time('sunrise');
			$t->time('sunset');
			$t->integer('class_head');
			$t->integer('class_torso');
			$t->integer('class_legs');
			$t->integer('class_feet');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weather_examples');
	}

}
