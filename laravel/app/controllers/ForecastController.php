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
		$forecasts = ForecastWeather::where('city_id', Cookie::get('city_id'))->orderBy('forecast_date')->get();

		$days = array();

		for ($i = 0; $i < count($forecasts); $i++) 
		{
			array_push($days, array('high' => $forecasts[$i]->temperature_high, 'low' => $forecasts[$i]->temperature_low, 'temperature' => $forecasts[$i]->temperature));
		
			//Get the decision tree and process the needed clothes
	        $treeController = new TreeController();
	        $treeController->loadTrees();
	        $reading = $treeController->transformReading($forecast[$i]);
	        $output = $treeController->classifyReading($reading);

	        //We could not figure out something, fallback
	        if (in_array(-1, $output))
	        {
	            $view->message = Lang::get('guides.clothes_error');
	            $view->head = 1;
	            $view->body = 3;
	            $view->pants = 1;
	            $view->boots = 1;
	        }
	        else
	        {
	            $view->head = $output[0];
	            $view->body = $output[1];
	            $view->pants = $output[2];
	            $view->boots = $output[3];
	        }
		}

		$tasks = array(array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'), array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'), array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'), array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'), array('task1' => 'Kupi mleko', 'task2' => 'Kupi sir', 'task3' => 'Kupi jogurt'));

		for ($i = 0; $i < min(count($tasks), count($forecasts)); $i++)
		{
			$days[$i]['task1'] = $tasks[$i]['task1'];
			$days[$i]['task2'] = $tasks[$i]['task2'];
			$days[$i]['task3'] = $tasks[$i]['task3'];
		}

		$view->days = $days;

		return $view;
	}
}