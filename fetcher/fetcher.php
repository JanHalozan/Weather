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

//Weather conditions, order is priority, if a read returns more conditions, the topmost is picked
$weather_conditions = array(
    '09' => 'Shower rain',
    '10' => 'Rain',
    '11' => 'Thunderstorm',
    '13' => 'Snow',
    '01' => 'Sky is clear',
    '02' => 'Few clouds',
    '03' => 'Scattered clouds',
    '04' => 'Broken clouds',
    '50' => 'Mist'
);


//Current weather reading data structure
class CurrentReading
{
    //Data for reading, temp is in celsius, pressure in hPa (hectoPascal), wind_speed in mps (meters per second),
    //humidity and clouds in percentage (0-100) and wind_direction in degrees
    public $city_id;
    public $weather_condition;
    public $reading_time;
    public $temperature;
    public $pressure;
    public $humidity;
    public $wind_speed;
    public $wind_direction;
    public $cloudiness;
    public $sunrise;
    public $sunset;
    public $day;
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
        CURLOPT_TIMEOUT => 5,
        CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/weather?id='.$city_data['api_id'].'&APPID='.$owm_api_key,
        CURLOPT_USERAGENT => 'Weatherbound'
    ));

    //Make request to API
    $response = curl_exec($curl);
    curl_close($curl);

    //Parse response
    if ($response)
    {
        $json_data = json_decode($response, true);

        if ($json_data && isset($json_data['dt']))
        {
            //Create reading
            $reading = new CurrentReading();

            //Read information
            $reading->city_id = $city_data['id'];
            $reading->reading_time = date('d-m-Y H:i:s', $json_data['dt']);
            $reading->temperature = floatval($json_data['main']['temp']) - 273.15;
            $reading->pressure = floatval($json_data['main']['pressure']);
            $reading->humidity = floatval($json_data['main']['humidity']);
            $reading->wind_speed = floatval($json_data['wind']['speed']);
            $reading->wind_direction = intval($json_data['wind']['deg']);
            $reading->cloudiness = intval($json_data['clouds']['all']);
            $reading->sunrise = date('d-m-Y H:i:s', $json_data['sys']['sunrise']);
            $reading->sunset = date('d-m-Y H:i:s', $json_data['sys']['sunset']);

            //Read all weather conditions
            $weather_conditions_read = array();
            foreach ($json_data['weather'] as $weather)
            {
                $day = substr($weather['icon'], 2, 1) == 'd'? true : false;
                array_push($weather_conditions_read, substr($weather['icon'], 0, 2));
            }

            //Save day information
            $reading->day = $day;

            //Pick only the topmost
            global $weather_conditions;
            foreach ($weather_conditions as $condition_key => $condition_value)
            {
                if (is_integer(array_search($condition_key, $weather_conditions_read)))
                {
                    $reading->weather_condition = $condition_value;
                    break;
                }
            }
            return $reading;
        }
        else return null;
    }
    else return null;
}

//Create globals and constants that will be used on the entire fetcher
$database = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');

//Get a list of cities to fetch data for
$cities = mysqli_query($database, "SELECT ci.id, ci.name, ci.api_id, co.name as country, co.country_code FROM cities as ci, countries as co WHERE ci.country_id = co.id");
if ($cities)
{
    //Read information for each city and store parsed information in database
    foreach ($cities as $city)
    {
        var_dump($city);
        $reading = owmFetch($city);
        var_dump($reading);
    }
}

mysqli_close($database);



