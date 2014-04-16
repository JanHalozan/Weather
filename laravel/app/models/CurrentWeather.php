<?php
/**
 * Created by PhpStorm.
 * User: janhalozan
 * Date: 4/15/14
 * Time: 3:01 PM
 *
 * Made for retrieving data for the current weather
 *
 */

class CurrentWeather extends Eloquent
{
    protected  $table = 'current_weather';

    //Gets the current weather into for the place
    public static function currentConditionForPlace($place)
    {
        //Get the data
        $data = $place . ' is a beautiful place';


        return $data;
    }
} 