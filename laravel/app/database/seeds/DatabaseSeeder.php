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

        $this->call('CitiesTableSeeder');
		$this->call('TestTableSeeder');
	}

}

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert(array(
            array('name' => 'Maribor', 'woeid' => '530779'),
            array('name' => 'Koper', 'woeid' => '530447'),
            array('name' => 'Ljubljana', 'woeid' => '530634'),
            array('name' => 'Ptuj', 'woeid' => '531279')
        ));
    }
}

class TestTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('test')->insert(array(
			array('test_text' => 'lep dan', 'working' => 1),
			array('test_text' => 'ni lep dan', 'working' => 0)
		));
	}
}
