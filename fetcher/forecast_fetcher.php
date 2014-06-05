<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 5/29/14
 * Time: 6:23 PM
 */

//API keys
//Open weather map
$owm_api_key = '65fec2c75fb2d93d3128cf9f7b38b8d0';

//Set timezone to be sure
date_default_timezone_set('GMT');

//No time limits
set_time_limit(0);

//Weather conditions, order is priority, if a read returns more conditions, the topmost is picked
$weather_conditions = array(
    '09' => 'shower_rain',
    '10' => 'rain',
    '11' => 'thunderstorm',
    '13' => 'snow',
    '01' => 'clear_sky',
    '02' => 'few_clouds',
    '03' => 'scattered_clouds',
    '04' => 'broken_clouds',
    '50' => 'mist'
);

//Forecast weather reading data structure
class ForecastReading
{
    //Data for reading, temp is in celsius, pressure in hPa (hectoPascal), wind_speed in mps (meters per second),
    //humidity and clouds in percentage (0-100) and wind_direction in degrees
    public $city_id;
    public $date;
    public $weather_condition;
    public $temperature;
    public $temperature_max;
    public $temperature_min;
    public $pressure;
    public $humidity;
    public $wind_speed;
    public $wind_direction;
    public $cloudiness;
}

function fetchData($city_data)
{
    global $owm_api_key;
    //Create curl request
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/forecast/daily?id='.$city_data['api_id'].'&mode=json&units=metric&cnt=6&APPID='.$owm_api_key,
        CURLOPT_USERAGENT => 'Weatherbound'
    ));

    //Make request to API
    $response = curl_exec($curl);
    curl_close($curl);

    //Parse response
    if ($response)
    {
        $json_data = json_decode($response, true);

        if ($json_data && isset($json_data['city']))
        {
            $reading_array = array();
            //Skip first forecast (today)
            $first_skip = false;

            foreach($json_data['list'] as $daily)
            {
                if ($first_skip == false)
                {
                    $first_skip = true;
                    continue;
                }

                //Create reading
                $reading = new ForecastReading();

                $reading->city_id = intval($city_data['id']);
                $reading->temperature = floatval($daily['temp']['day']);
                $reading->temperature_min = floatval($daily['temp']['min']);
                $reading->temperature_max = floatval($daily['temp']['max']);
                $reading->cloudiness = intval($daily['clouds']);
                $reading->pressure = floatval($daily['pressure']);
                $reading->humidity = intval($daily['humidity']);
                $reading->wind_speed = floatval($daily['speed']);
                $reading->wind_direction = intval($daily['deg']);
                $reading->date = date('Y-m-d', $daily['dt']);

                //Read all weather conditions
                $weather_conditions_read = array();
                foreach ($daily['weather'] as $weather)
                {
                    array_push($weather_conditions_read, substr($weather['icon'], 0, 2));
                }

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

                array_push($reading_array, $reading);
            }

            return $reading_array;
        }
    }
}

//Connect to database
$database = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');

//Get a list of conditions
$conditions = mysqli_query($database, "SELECT * FROM weather_conditions");

//Get a list of cities to fetch forecast for
$cities = mysqli_query($database, "SELECT DISTINCT(ci.name), ci.id, ci.api_id FROM cities as ci");

if ($cities && $conditions)
{

    //Create a friendly array of conditions
    $conditions_array = array();
    foreach ($conditions as $c)
    {
        $conditions_array[$c['condition']] = $c['id'];
    }

    //Fetch data for each city
    foreach ($cities as $city)
    {
        $readings = fetchData($city);

        if ($readings == null) continue;

        //Clear db
        mysqli_query($database, "DELETE FROM weather_forecast WHERE city_id = ". $readings[0]->city_id);

        //Save readings into DB
        foreach ($readings as $reading)
        {
            //Get weather condition id
            $condition_id = intval($conditions_array[$reading->weather_condition]);

            $sql = "INSERT INTO weather_forecast(city_id, temperature, temperature_low, temperature_high, pressure,
                humidity, wind_speed, wind_direction, forecast_date, condition_id) VALUES (".$reading->city_id.",
                ".$reading->temperature.", ".$reading->temperature_min.", ".$reading->temperature_max.",
                ".$reading->pressure.", ".$reading->humidity.", ".$reading->wind_speed.", ".$reading->wind_direction.",
                '".$reading->date."', ".$condition_id.")";
            mysqli_query($database, $sql);
        }
    }
}

mysqli_close($database);