<?php

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert(array(
        	array('username' => 'luka', 'password' => Hash::make('geslo'), 'activated' => 1, 'locale' => 'us', 'is_admin' => true),
        	array('username' => 'jan', 'password' => Hash::make('geslo'), 'activated' => 1, 'locale' => 'us', 'is_admin' => true),
        	array('username' => 'saso', 'password' => Hash::make('geslo'), 'activated' => 1, 'locale' => 'us', 'is_admin' => true),
        	array('username' => 'zoran', 'password' => Hash::make('geslo'), 'activated' => 1, 'locale' => 'us', 'is_admin' => true),
        	array('username' => 'martin', 'password' => Hash::make('geslo'), 'activated' => 1, 'locale' => 'us', 'is_admin' => true)
        ));
    }
}