<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 4/23/14
 * Time: 4:47 PM
 */

class CityAddController extends BaseController
{
    function index()
    {
        $view = View::make('city_add');
        $tree_controller = new TreeController();
        $tree_controller->loadTrees();
        $reading = CurrentWeather::first();
        $reading = $tree_controller->transformReading($reading);
        //var_dump($tree_controller->classifyReading($reading));
        var_dump($tree_controller->classifyTasks($reading));
        return $view;
    }

    function searchCity()
    {
        if (Request::ajax())
        {
            //Get post information
            $search_text = Input::get('search_text');

            //Make request for city information
            //Create curl request
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_TIMEOUT => 5,
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

        return "NULL";
    }
}