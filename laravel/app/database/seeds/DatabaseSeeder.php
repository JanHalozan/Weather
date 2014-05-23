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
        $this->call('CountrySeeder');
        $this->call('CitiesSeeder');
        $this->call('WeatherConditionSeeder');
	}

}

class CountrySeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->insert(array(
            array('name' => 'Slovenia', 'country_code' => 'SI'),
            array('name' => 'Germany', 'country_code' => 'DE'),
            array('name' => 'Australia', 'country_code' => 'AU'),
            array('name' => 'Japan', 'country_code' => 'JP'),
            array('name' => 'South Africa', 'country_code' => 'ZA'),
            array('name' => 'United Kingdom', 'country_code' => 'GB'),
            array('name' => 'United States', 'country_code' => 'US')
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
                'latitude' => 46.05, 'longitude' => 14.50, 'api_id' => '3201730'),
            array('name' => 'Chicago', 'country_id' => DB::table('countries')->where('name', 'United States')->pluck('id'),
                'latitude' => 41.85, 'longitude' => -87.65, 'api_id' => '4887398'),
            array('name' => 'Los Angeles', 'country_id' => DB::table('countries')->where('name', 'United States')->pluck('id'),
                'latitude' => 34.05, 'longitude' => -118.24, 'api_id' => '5368361'),
            array('name' => 'New York', 'country_id' => DB::table('countries')->where('name', 'United States')->pluck('id'),
                'latitude' => 40.71, 'longitude' => -74.01, 'api_id' => '5128581'),
            array('name' => 'London', 'country_id' => DB::table('countries')->where('name', 'United Kingdom')->pluck('id'),
                'latitude' => 51.51, 'longitude' => -0.13, 'api_id' => '2643743'),
            array('name' => 'Johannesburg', 'country_id' => DB::table('countries')->where('name', 'South Africa')->pluck('id'),
                'latitude' => -26.2, 'longitude' => 28.04, 'api_id' => '993800'),
            array('name' => 'Sydney', 'country_id' => DB::table('countries')->where('name', 'Australia')->pluck('id'),
                'latitude' => 46.14, 'longitude' => -60.18, 'api_id' => '6354908'),
            array('name' => 'Berlin', 'country_id' => DB::table('countries')->where('name', 'Germany')->pluck('id'),
                'latitude' => 52.52, 'longitude' => 13.41, 'api_id' => '2950159'),
            array('name' => 'Tokyo', 'country_id' => DB::table('countries')->where('name', 'Japan')->pluck('id'),
                'latitude' => 35.69, 'longitude' => 139.69, 'api_id' => '1850147')
        ));
    }
}

class WeatherConditionSeeder extends Seeder
{
    public function run()
    {
        DB::table('weather_conditions')->insert(array(
            array('condition' => 'clear_sky'),
            array('condition' => 'few_clouds'),
            array('condition' => 'scattered_clouds'),
            array('condition' => 'broken_clouds'),
            array('condition' => 'shower_rain'),
            array('condition' => 'rain'),
            array('condition' => 'thunderstorm'),
            array('condition' => 'snow'),
            array('condition' => 'mist'),
        ));
    }
}