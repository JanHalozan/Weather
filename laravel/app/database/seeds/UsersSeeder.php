<?php

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert(array(
            array('username' => 'test', 'password' => Hash::make('geslo'), 'activated' => 1, 'locale' => 'us')
        ));
    }
}