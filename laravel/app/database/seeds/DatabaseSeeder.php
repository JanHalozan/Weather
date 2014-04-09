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

		$this->call('TestTableSeeder');
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
