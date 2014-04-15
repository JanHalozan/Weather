<?php
/**
 * Created by PhpStorm.
 * User: janhalozan
 * Date: 4/13/14
 * Time: 11:47 AM
 */

//TODO seperate code into more files once more APIs are used

//API keys
//Open weather map
$owm_api_key = '65fec2c75fb2d93d3128cf9f7b38b8d0';

//Set timezone to be sure
date_default_timezone_set('GMT');

//Current weather reading data structure
class CurrentReading
{
    //Data for reading, temp is in celsius, pressure in hPa (hectoPascal), wind_speed in mps (meters per second),
    //humidity and clouds in percentage (0-100) and wind_direction in degrees
    public $city_id;
    public $weather_condition;
    public $reading_time;
    public $temp;
    public $pressure;
    public $humidity;
    public $wind_speed;
    public $wind_direction;
    public $clouds;
}

//Open weather map API fetch
function owmFetch($city_data)
{
    global $owm_api_key;
    //Create curl request
    $curl = curl_init();

    //TODO change to API id of city
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 3,
        CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/weather?q='.$city_data['name'].','.
            $city_data['country_code'].'&APPID='.$owm_api_key,
        CURLOPT_USERAGENT => 'Weatherbound'
    ));

    //Make request to API
    $response = curl_exec($curl);
    curl_close($curl);

    //Parse response
    if ($response)
    {
        $json_data = json_decode($response, true);

        if ($json_data)
        {
            //Create reading
            $reading = new CurrentReading();

            //TODO change to id once we have that information
            $reading->city_id = $city_data['name'];
            $reading->weather_condition = $json_data['weather'][0]['main'];
            $reading->reading_time = date('d-m-Y H:i:s', $json_data['dt']);
            $reading->temp = floatval($json_data['main']['temp']) - 273.15;
            $reading->pressure = floatval($json_data['main']['pressure']);
            $reading->humidity = floatval($json_data['main']['humidity']);
            $reading->wind_speed = floatval($json_data['wind']['speed']);
            $reading->wind_direction = intval($json_data['wind']['deg']);
            $reading->clouds = intval($json_data['clouds']['all']);

            return $reading;
        }
    }
}

//Create globals and constants that will be used on the entire fetcher
//$database = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');

//Get a list of cities to fetch data for
//TODO add database read
//Temp array
$cities = array(
    0 => array(
        'name' => 'Maribor',
        'country_code' => 'SI',
    ),
    1 => array(
        'name' => 'Ljubljana',
        'country_code' => 'SI'
    ),
    2 => array(
        'name' => 'Berlin',
        'country_code' => 'DE'
    ),
    3 => array(
        'name' => 'London',
        'country_code' => 'GB'
    ),
);

//Test calls
foreach ($cities as $city)
{
    $reading = owmFetch($city);
    var_dump($reading);
}



