<?php

class ForecastController extends BaseController 
{
	public function index()
	{
		//No city to show data for, get him to the 
		if (!Cookie::has('city_id'))
			return Redirect::intended()->with('message', Lang::get('guides.forecast_error'));

		$view = View::make('forecast');

		//Query the forecast for the city in cookie
		$conditions = ForecastWeather::find(Cookie::get('city_id'));

		return $view;
	}
}