<?php

class ActivitiesSeeder extends Seeder
{
    public function run()
    {
        DB::table('activities')->insert(
        	array(
        		// Type 1 - Activities at home
	            array(
	            	'name' => 'watch_tv',
	                'activity_type' => '1',
	                'user_id' => '-1'
	            ),
                array(
                    'name' => 'clean_room',
                    'activity_type' => '1',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'take_nap',
                    'activity_type' => '1',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'video_games',
                    'activity_type' => '1',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'play_instrument',
                    'activity_type' => '1',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'read_book',
                    'activity_type' => '1',
                    'user_id' => '-1'
                ),
	            // Type 2 - Outdoor sport activities
	            array(
	            	'name' => 'go_run',
	                'activity_type' => '2',
	                'user_id' => '-1'
	            ),
                array(
                    'name' => 'take_walk',
                    'activity_type' => '2',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'sport_with_friend',
                    'activity_type' => '2',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'go_bike',
                    'activity_type' => '2',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'picnic_park',
                    'activity_type' => '2',
                    'user_id' => '-1'
                ),
	            // Type 3 - Winter activities
	            array(
	            	'name' => 'build_snowman',
	                'activity_type' => '3',
	                'user_id' => '-1'
	            ),
                array(
                    'name' => 'go_sky',
                    'activity_type' => '3',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'drink_tea',
                    'activity_type' => '3',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'make_snow_fort',
                    'activity_type' => '3',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'have_snow_fight',
                    'activity_type' => '3',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'clear_snow',
                    'activity_type' => '3',
                    'user_id' => '-1'
                ),
	            // Type 4 - Indoor sport activities
	            array(
	            	'name' => 'visit_fitness',
	                'activity_type' => '4',
	                'user_id' => '-1'
	            ),
                array(
                    'name' => 'work_at_home',
                    'activity_type' => '4',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'sport_indoors',
                    'activity_type' => '4',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'push_ups',
                    'activity_type' => '4',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'joga',
                    'activity_type' => '4',
                    'user_id' => '-1'
                ),
	            // Type 5 - Events aka. movies, concerts ...
	            array(
	            	'name' => 'go_to_movies',
	                'activity_type' => '5',
	                'user_id' => '-1'
	            ),
                array(
                    'name' => 'go_to_concert',
                    'activity_type' => '5',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'invite_coffee',
                    'activity_type' => '5',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'throw_party',
                    'activity_type' => '5',
                    'user_id' => '-1'
                ),
                array(
                    'name' => 'go_to_meetup',
                    'activity_type' => '5',
                    'user_id' => '-1'
                    )
	        )
        );
    }
}