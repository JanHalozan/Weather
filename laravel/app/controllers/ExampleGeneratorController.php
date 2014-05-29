<?php
/**
 * Created by PhpStorm.
 * User: Zoran
 * Date: 5/23/14
 * Time: 10:47 AM
 */

class ExampleGeneratorController extends BaseController
{
    function index()
    {
        $view = View::make('example_generator');

        //Generate random latitude and longitude
        $lat = rand(-9000,9000) / 100;
        $lon = rand(-18000,18000) / 100;

        //Api key
        $owm_api_key = '65fec2c75fb2d93d3128cf9f7b38b8d0';

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

        //Create curl request
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lon.'&units=metric&APPID='.$owm_api_key,
            CURLOPT_USERAGENT => 'Weatherbound'
        ));

        //Make request to API
        $response = curl_exec($curl);
        curl_close($curl);


        if ($response)
        {
            $json_data = json_decode($response, true);
            $view->json_data = $json_data;

            if ($json_data && isset($json_data['dt']))
            {
                $view->temp = $json_data['main']['temp'];
                $view->press = $json_data['main']['pressure'];
                $view->humid = $json_data['main']['humidity'];
                $view->wind_sp = $json_data['wind']['speed'];
                $view->wind_dir = $json_data['wind']['deg'];
                $view->cloudiness = $json_data['clouds']['all'];
                $view->sunrise = date('Y-m-d H:i:s', $json_data['sys']['sunrise']);
                $view->sunset = date('Y-m-d H:i:s', $json_data['sys']['sunset']);

                //Read all weather conditions
                $weather_conditions_read = array();
                $view->day = true;
                foreach ($json_data['weather'] as $weather)
                {
                    $view->day = substr($weather['icon'], 2, 1) == 'd'? '1' : '0';
                    array_push($weather_conditions_read, substr($weather['icon'], 0, 2));
                }

                foreach ($weather_conditions as $condition_key => $condition_value)
                {
                    if (is_integer(array_search($condition_key, $weather_conditions_read)))
                    {
                        $view->condition = $condition_value;
                        break;
                    }
                }
            }
        }

        return $view;
    }

    function saveExample()
    {
        //Save example to database
        //Get condition id from database
        $condition_id = DB::table('weather_conditions')->where('condition', Input::get('condition'))->pluck('id');

        //Insert
        DB::table('weather_examples')->insert(
            array('condition_id' => $condition_id,
                'temperature' => Input::get('temperature'),
                'pressure' => Input::get('pressure'),
                'humidity' => Input::get('humidity'),
                'wind_direction' => Input::get('wind_direction'),
                'wind_speed' => Input::get('wind_speed'),
                'sunrise' => Input::get('sunrise'),
                'sunset' => Input::get('sunset'),
                'day' => Input::get('day'),
                'cloudiness' => Input::get('cloudiness'),
                'class_head' => Input::get('head'),
                'class_torso' => Input::get('torso'),
                'class_legs' => Input::get('legs'),
                'class_feet' => Input::get('boots'),
            )
        );

        $view = View::make('example_generator');
        return $view;
    }
}