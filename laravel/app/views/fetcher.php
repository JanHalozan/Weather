<?php
/**
 * Created by PhpStorm.
 * User: janhalozan
 * Date: 4/13/14
 * Time: 11:47 AM
 */

//Yahoo weather API fetch

//First lets get the missing WOEIDs
$cities = DB::select('SELECT name FROM cities WHERE woeid = NULL');

foreach ($cities as $city)
{
    //Lookup and insert the missing ones
}

$cities = DB::select('SELECT name, woeid FROM cities');

foreach ($cities as $city)
{
    $response = file_get_contents('http://weather.yahooapis.com/forecastrss?w=' . $city->woeid);

    $xml = simplexml_load_string($response);

    var_dump($xml->asXML());
}
