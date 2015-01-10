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

        //Get the condition string
        $condition = Conditions::find($weatherInfo->condition_id)->condition;

        //Get country data
        $country = Countries::find($city->country_id);

        //Generate JS data blob for HUD usage
        $data = array('temperature' => $weatherInfo->temperature, 'city_name' => $city->name, 'condition' => Lang::get('conditions.' . $condition),
            'country' => $country->name);
        $view->data_blob = json_encode($data);

    	return $view;
    }
}