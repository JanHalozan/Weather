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
		$forecasts = ForecastWeather::where('id', Cookie::get('city_id'))->orderBy('forecast_date')->get();

		$days = array();

		foreach ($forecasts as $forecast)
			array_push($days, array('high' => $forecast->temperature_high, 'low' => $forecast->temperature_low, 'temperature' => $forecast->temperature));

		$tasks = array(array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'), array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'), array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'));

		for ($i = 0; $i < min(count($tasks), count($forecasts)); $i++)
		{
			$days[$i]['task1'] = $tasks[$i]['task1'];
			$days[$i]['task2'] = $tasks[$i]['task2'];
			$days[$i]['task3'] = $tasks[$i]['task3'];
		}

		var_dump($days);

		$view->days = $days;

		//$view->days = array(array("temperature" => 20, "high" => 22, "low" => 15, "task1" => "Fuck yourself", "task2" => "HEHE", "task3" => "Burek"), array("temperature" => 20, "high" => 22, "low" => 15, "task1" => "Fuck yourself", "task2" => "HEHE", "task3" => "Burek"), array("temperature" => 20, "high" => 22, "low" => 15, "task1" => "Fuck yourself", "task2" => "HEHE", "task3" => "Burek"), array("temperature" => 20, "high" => 22, "low" => 15, "task1" => "Fuck yourself", "task2" => "HEHE", "task3" => "Burek"), array("temperature" => 20, "high" => 22, "low" => 15, "task1" => "Fuck yourself", "task2" => "HEHE", "task3" => "Burek"));

		return $view;
	}
}