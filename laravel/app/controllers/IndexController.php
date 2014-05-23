<?php

/**
 * Created by PhpStorm.
 * User: janhalozan
 * Date: 4/15/14
 * Time: 2:37 PM
 *
 * Route: /
 * Model: <none - yet>
 *
 *
 */
class IndexController extends BaseController 
{

    //This is the default action
    public function index()
    {
        $view = View::make('index');

        if (Cookie::get('city_id'))
        {
            $city = Cities::find(Cookie::get('city_id'));
        }
        else //There is no city in the cookie yet, get an approximate user location
        {
            $ip = $_SERVER['REMOTE_ADDR'];
            //$ip = "92.53.136.233";
            $url = "https://freegeoip.net/xml/" . $ip;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            $response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($status == 200)
            {
                $dom = new DOMDocument('1.0', 'utf-8');
                $dom->loadXML($response);

                $xPath = new DOMXPath($dom);

                $lat = $xPath->query('//Latitude')->item(0)->textContent;
                $lon = $xPath->query('//Longitude')->item(0)->textContent;

                $city = Cities::findNearest($lat, $lon);

                Cookie::forever('city_id', $city->id);
            }
            else
            {
                $view->message = "We were unable to find a nearby location, using Maribor as a fallback.";

                $city = Cities::first();
            }
        }

        //TODO finish the population of view with weather data
        //Populate the view with weather data
        $weatherInfo = CurrentWeather::where('city_id', '=', $city->id)->firstOrFail();
        $view->temperature = $weatherInfo->temperature;

        //Get the condition string
        $condition = Conditions::find($weatherInfo->condition_id)->condition;
        $view->condition = Lang::get('conditions.' . $condition);

        //Populate the view with city & country data
        $view->cityName = $city->name;

        $country = Countries::find($city->country_id);
        $view->countryName = $country->name;

        //FACT
        try
        {
            $randomFact = rand(0, 127);
            $lastFactId = Facts::orderBy('id', 'desc')->first()->id;
            $view->fact = Facts::find($lastFactId - $randomFact)->fact;
        }
        catch (Exception $e)
        {
            $view->fact = "That our random fact feature is not working.";
        }

        if (Session::get('message'))
            $view->message = Session::get('message');

        return $view;
    }

    public function cityPicker()
    {
        //TODO implement a nice city picker
        $view = View::make('citypicker');

        $view->cities = Cities::all(array('name'));

        return $view;
    }

    public function cityWeather($cityName)
    {
        //TODO implement logic
        $cityName = urldecode($cityName);

        return "Requesting data for " . $cityName;
    }
}