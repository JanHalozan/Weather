<?php

class ActivitiesSeeder extends Seeder
{
    public function run()
    {
        DB::table('activities')->insert(
        	array(
        		// Type 1 - Activities at home
	            array(
	            	'name' => 'Watch TV',
	                'activity_type' => '1',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Clean',
	                'activity_type' => '1',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Take a nap',
	                'activity_type' => '1',
	                'user_id' => '-1'
	            ),
	            // Type 2 - Outdoor sport activities
	            array(
	            	'name' => 'Go running',
	                'activity_type' => '2',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Take a walk',
	                'activity_type' => '2',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Sport with friends',
	                'activity_type' => '2',
	                'user_id' => '-1'
	            ),
	            // Type 3 - Winter activities
	            array(
	            	'name' => 'Build a snowman',
	                'activity_type' => '3',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Go skiing',
	                'activity_type' => '3',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Drink a cup of tea',
	                'activity_type' => '3',
	                'user_id' => '-1'
	            ),
	            // Type 4 - Indoor sport activities
	            array(
	            	'name' => 'Visit a fitnes studio',
	                'activity_type' => '4',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Work out at home',
	                'activity_type' => '4',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Play squash',
	                'activity_type' => '4',
	                'user_id' => '-1'
	            ),
	            // Type 5 - Events aka. movies, concerts ...
	            array(
	            	'name' => 'Go to the movies',
	                'activity_type' => '5',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Go to a concert',
	                'activity_type' => '5',
	                'user_id' => '-1'
	            ),
	            array(
	            	'name' => 'Invite someone to coffe',
	                'activity_type' => '5',
	                'user_id' => '-1'
	            )
	        )
        );
    }
}