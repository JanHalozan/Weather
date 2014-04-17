<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseSetup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('name', 45);
            $t->string('continent', 45);
        });
		
		Schema::create('cities', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('name', 45);
			$t->integer('country_id')->references('id')->on('countries');
			$t->float('longitude');
			$t->float('latitude');
        });
		
		Schema::create('weather_conditions', function(Blueprint $t)
        {
            $t->increments('id');
			$t->string('condition', 45);
        });
		
		Schema::create('weather_current', function(Blueprint $t)
        {
            $t->bigIncrements('id');
			$t->integer('city_id')->references('id')->on('cities');
			$t->dateTime('reading_time');
			$t->integer('condition_id')->references('id')->on('weather_conditions');
			$t->float('temperature');
			$t->float('pressure');
			$t->integer('humidity');
			$t->integer('wind_direction');
			$t->float('wind_speed');
			$t->time('sunrise');
			$t->time('sunset');
        });
		
		Schema::create('weather_forecast', function(Blueprint $t)
        {
            $t->bigIncrements('id');
			$t->integer('city_id')->references('id')->on('cities');
			$t->date('forecast_date');
			$t->integer('condition_id')->references('id')->on('weather_conditions');
			$t->float('temperature_low');
			$t->float('temperature_high');
			$t->float('pressure');
			$t->integer('humidity');
			$t->integer('wind_direction');
			$t->float('wind_speed');
        });
		
		Schema::create('weather_history', function(Blueprint $t)
        {
            $t->bigIncrements('id');
			$t->integer('city_id')->references('id')->on('cities');
			$t->dateTime('reading_time');
			$t->integer('condition_id')->references('id')->on('weather_conditions');
			$t->float('temperature');
			$t->float('pressure');
			$t->integer('humidity');
			$t->integer('wind_direction');
			$t->float('wind_speed');
        });
		
		Schema::create('users', function(Blueprint $t)
        {
            $t->bigIncrements('id');
			$t->string('username', 60)->unique();
			$t->string('password', 32);
			$t->boolean('activated')->default('0');
			$t->string('locale', 2);
			$t->string('avatar', 60)->nullable();
        });
		
		Schema::create('users_cities', function(Blueprint $t)
        {
            $t->bigIncrements('id');
			$t->integer('city_id')->references('id')->on('cities');
			$t->bigInteger('user_id')->references('id')->on('users');
        });
		
		Schema::create('activity_types', function(Blueprint $t)
        {
            $t->increments('id');
			$t->string('type', 45);
        });
		
		Schema::create('activities', function(Blueprint $t)
        {
            $t->increments('id');
			$t->string('name', 45);
			$t->integer('activity_type')->references('id')->on('activity_types');
			$t->bigInteger('user_id')->references('id')->on('users')->default('-1');
        });
		
		Schema::create('cloth_types', function(Blueprint $t)
        {
            $t->increments('id');
			$t->string('type', 45);
        });
		
		Schema::create('clothes', function(Blueprint $t)
        {
            $t->increments('id');
			$t->string('name', 45);
			$t->integer('cloth_type_id')->references('id')->on('cloth_types');
			$t->string('image_location', 60);
        });	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clothes');
		Schema::drop('cloth_types');
		Schema::drop('activities');
		Schema::drop('activity_types');
		Schema::drop('users_cities');
		Schema::drop('users');
		Schema::drop('weather_history');
		Schema::drop('weather_forecast');
		Schema::drop('weather_current');
		Schema::drop('weather_conditions');
		Schema::drop('cities');
		Schema::drop('countries');
	}

}
