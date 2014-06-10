<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 4/23/14
 * Time: 4:47 PM
 */
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

class CityAddController extends BaseController
{
    private $owm_api_key = '65fec2c75fb2d93d3128cf9f7b38b8d0';

    function index()
    {
        $view = View::make('city_add');
        $this->fetchDataForCity(27);
        return $view;
    }

    function addCity()
    {
        if (Request::ajax())
        {
            //Get data
            $data = Input::get('data');
            $data = json_decode($data, true);

            if ($data)
            {
                //Check if city already in Database
                $city = DB::table('cities')->where('api_id', $data['id'])->first();
                if ($city == null)
                {
                    //Check country
                    $country_data = $this->getCountry($data['country']);
                    $country = DB::table('countries')->where('name', $country_data['name'])->first();

                    //Add country if not in DB
                    if ($country == null)
                    {
                        $id_country = DB::table('countries')->insertGetId(
                            array('name' => $country_data['name'], 'country_code' => $country_data['code'])
                        );
                    }
                    else
                    {
                        $id_country = $country->id;
                    }

                    //Add city
                    $city_id = DB::table('cities')->insertGetId(
                        array('name' => $data['name'], 'country_id' => $id_country, 'api_id' => $data['id'],
                            'longitude' => $data['longitude'], 'latitude' => $data['latitude'])
                    );

                    $this->fetchDataForCity($city_id);

                    return "TRUE";
                }
            }
            return "NULL";
        }
    }

    private function fetchDataForCity($id)
    {
        //Current weather fetch
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
        //Get city data first
        $city = Cities::where('id', $id)->first();

        //Create curl request
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/weather?id='.$city->api_id.'&APPID='.$this->owm_api_key,
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
                $reading->city_id = $city->id;
                $reading->reading_time = date('Y-m-d H:i:s', $json_data['dt']);
                $reading->temperature = floatval($json_data['main']['temp']) - 273.15;
                $reading->pressure = floatval($json_data['main']['pressure']);
                $reading->humidity = floatval($json_data['main']['humidity']);
                $reading->wind_speed = floatval($json_data['wind']['speed']);
                $reading->wind_direction = intval($json_data['wind']['deg']);
                $reading->cloudiness = intval($json_data['clouds']['all']);
                $reading->sunrise = date('Y-m-d H:i:s', $json_data['sys']['sunrise']);
                $reading->sunset = date('Y-m-d H:i:s', $json_data['sys']['sunset']);

                //Read all weather conditions
                $weather_conditions_read = array();
                $day = true;
                foreach ($json_data['weather'] as $weather)
                {
                    $day = substr($weather['icon'], 2, 1) == 'd'? '1' : '0';
                    array_push($weather_conditions_read, substr($weather['icon'], 0, 2));
                }

                //Save day information
                $reading->day = $day;

                //Pick only the topmost
                foreach ($weather_conditions as $condition_key => $condition_value)
                {
                    if (is_integer(array_search($condition_key, $weather_conditions_read)))
                    {
                        $reading->weather_condition = $condition_value;
                        break;
                    }
                }

                //Find correct condition ID
                $condition_id = DB::table('weather_conditions')->where('condition', $reading->weather_condition)->first();

                //Insert into DB
                DB::table('weather_current')->insert(array(
                    'city_id' => $reading->city_id,
                    'reading_time' => $reading->reading_time,
                    'condition_id' => $condition_id->id,
                    'temperature' => $reading->temperature,
                    'pressure' => $reading->pressure,
                    'humidity' => $reading->humidity,
                    'wind_direction' => $reading->wind_direction,
                    'wind_speed' => $reading->wind_speed,
                    'sunrise' => $reading->sunrise,
                    'sunset' => $reading->sunset,
                    'cloudiness' => $reading->cloudiness,
                    'day' => $reading->day
                ));
            }
        }

        //Forecast fetch
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/forecast/daily?id='.$city->api_id.'&mode=json&units=metric&cnt=6&APPID='.$this->owm_api_key,
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
                //Delete old forecast data
                DB::table('weather_forecast')->where('city_id', $city->id)->delete();

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

                    $reading->city_id = intval($city->id);
                    $reading->temperature = floatval($daily['temp']['day']);
                    $reading->temperature_min = floatval($daily['temp']['min']);
                    $reading->temperature_max = floatval($daily['temp']['max']);
                    $reading->cloudiness = intval($daily['clouds']);
                    $reading->pressure = floatval($daily['pressure']);
                    $reading->humidity = intval($daily['humidity']);
                    $reading->wind_speed = isset($daily['speed'])? floatval($daily['speed']) : 0.0;
                    $reading->wind_direction = isset($daily['deg'])? intval($daily['deg']) : 0;
                    $reading->date = date('Y-m-d', $daily['dt']);

                    //Read all weather conditions
                    $weather_conditions_read = array();
                    foreach ($daily['weather'] as $weather)
                    {
                        array_push($weather_conditions_read, substr($weather['icon'], 0, 2));
                    }

                    //Pick only the topmost
                    foreach ($weather_conditions as $condition_key => $condition_value)
                    {
                        if (is_integer(array_search($condition_key, $weather_conditions_read)))
                        {
                            $reading->weather_condition = $condition_value;
                            break;
                        }
                    }

                    //Get condition id
                    //Find correct condition ID
                    $condition_id = DB::table('weather_conditions')->where('condition', $reading->weather_condition)->first();

                    //Insert into DB
                    DB::table('weather_forecast')->insert(array(
                        'city_id' => $reading->city_id,
                        'forecast_date' => $reading->date,
                        'condition_id' => $condition_id->id,
                        'temperature' => $reading->temperature,
                        'temperature_low' => $reading->temperature_min,
                        'temperature_high' => $reading->temperature_max,
                        'pressure' => $reading->pressure,
                        'humidity' => $reading->humidity,
                        'wind_direction' => $reading->wind_direction,
                        'wind_speed' => $reading->wind_speed,
                        'cloudiness' => $reading->cloudiness,
                    ));
                }
            }
        }
    }

    private function getCountry($name)
    {
        // input
        $input = $name;

        // check if input is country name or country code
        if (strlen($input) == 2)
            $isCountry = false;
        else if (strlen($input) > 2)
            $isCountry = true;
        else
            return null;

        if ($isCountry)
            $input = ucwords(strtolower($input));
        else
            $input = strtoupper($input);

        $html = file_get_contents('http://countrycode.org/');
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");

        $dom = new DOMDocument('1.0', 'utf-8');
        @$dom->loadHTML($html);
        $xPath = new DomXPath($dom);

        // if input contain country name
        if ($isCountry)
        {
            $country = $xPath->query("//tr[td[a[contains(., '$input')]]]/td");

            if ($country->length > 0) // if xPath returned result
            {
                $ret = array('name' => ltrim(rtrim($country->item(0)->nodeValue)), 'code' => substr($country->item(1)->nodeValue, 0, 2));
            }
            else // try to find matching country (input : 'United States of America' => result : 'United States')
            {
                for ($i = 0; $i < strlen($input); $i = $i + 1)
                {
                    $country = $xPath->query("//tr[td[a[contains(.,'" . substr($input, 0, $i) . "')]]]/td");
                    if ($country->length == 6)
                    {
                        $ret = array('name' => ltrim(rtrim($country->item(0)->nodeValue)), 'code' => substr($country->item(1)->nodeValue, 0, 2));
                        break;
                    }
                }
            }
        }
        else	// input is country code
        {
            $input .= " / ";
            $country = $xPath->query("//tr[td[contains(.,'$input')]]/td");

            if ($country->length == 6)
            {
                $country_name = ltrim(rtrim($country->item(0)->nodeValue));
                $ret = array('name' => $country_name, 'code' => substr($country->item(1)->nodeValue, 0, 2));
            }
            else
                return null;
        }
        return $ret;
    }

    function searchCity()
    {
        if (Request::ajax())
        {
            //Get post information
            $search_text = Input::get('search_text');
            $city = trim(explode(',', $search_text)[0]);
            $country = trim(explode(',', $search_text)[1]);
            $search_text = $city . ',' . $country;

            for ($i = 0; $i < 5; ++$i)
            {
                //Make request for city information
                //Create curl request
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/find?q='.$search_text.'&mode=json',
                    CURLOPT_USERAGENT => 'Weatherbound'
                ));

                //Make request to API

                $response = curl_exec($curl);
                curl_close($curl);

                if ($response)
                {
                    $json_data = json_decode($response, true);

                    if ($json_data && isset($json_data['count']) && $json_data['count'] == 1)
                    {
                        if ($json_data['list'][0]['name'] == false || $json_data['list'][0]['id'] == 0) return 'NULL';
                        return json_encode(array(
                            'id' => $json_data['list'][0]['id'],
                            'name' => $json_data['list'][0]['name'],
                            'country' => $json_data['list'][0]['sys']['country'],
                            'longitude' => $json_data['list'][0]['coord']['lon'],
                            'latitude' => $json_data['list'][0]['coord']['lat']
                        ));
                    }
                }
            }
        }

        return "NULL";
    }
}
