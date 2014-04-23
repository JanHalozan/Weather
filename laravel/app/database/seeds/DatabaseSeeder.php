<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        //$this->call('CountrySeeder');
        //$this->call('CitiesSeeder');
        $this->call('WeatherConditionSeeder');
	}

}

class CountrySeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->insert(array(
            array('name' => 'Slovenia', 'continent' => 'Europe', 'country_code' => 'SI'),
            array('name' => 'Germany', 'continent' => 'Europe', 'country_code' => 'DE'),
            array('name' => 'United Kingdom', 'continent' => 'Europe', 'country_code' => 'UK')
        ));
    }
}

class CitiesSeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert(array(
            array('name' => 'Maribor', 'country_id' => DB::table('countries')->where('name', 'Slovenia')->pluck('id'),
            'latitude' => 46.55, 'longitude' => 15.64, 'api_id' => '3195506'),
            array('name' => 'Ljubljana', 'country_id' => DB::table('countries')->where('name', 'Slovenia')->pluck('id'),
                'latitude' => 46.05, 'longitude' => 14.50, 'api_id' => '3196359'),
        ));
    }
}

class WeatherConditionSeeder extends Seeder
{
    public function run()
    {
        DB::table('weather_conditions')->insert(array(
            array('condition' => 'Sky is clear'),
            array('condition' => 'Few clouds'),
            array('condition' => 'Scattered clouds'),
            array('condition' => 'Broken clouds'),
            array('condition' => 'Shower rain'),
            array('condition' => 'Rain'),
            array('condition' => 'Thunderstorm'),
            array('condition' => 'Snow'),
            array('condition' => 'Mist'),
        ));
    }
}