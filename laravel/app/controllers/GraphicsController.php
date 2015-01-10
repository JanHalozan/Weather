<?php

class GraphicsController extends BaseController 
{
    //This is the default action
    public function index()
    {
    	$view = View::make('graphics');

    	//Get weather data
    	$city = Cities::first();
        $city->id = 2;
        $weatherInfo = CurrentWeather::where('city_id', '=', $city->id)->orderBy('reading_time', 'desc')->firstOrFail();

        //Generate JS data blob for HUD usage
        $data = array('temperature' => $weatherInfo->temperature, 'city_name' => $city->name);
        $view->data_blob = json_encode($data);

    	return $view;
    }
}