<?php

function getTask($type)
{
    // Get all tasks with activiti that has requiered posibility
    $tmp = Activities::where('activity_type', $type)->get();
    // Pick one task randomli among those chosen tasks
    $max = Activities::where('activity_type', $type)->where('user_id', -1)->count();
    $randTask = rand(0, $max - 1);

    return $tmp[$randTask]->name;
}

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

			// ----------------- T INFO --------------------
			array_push($days, array('high' => $forecasts[$i]->temperature_high, 'low' => $forecasts[$i]->temperature_low, 'temperature' => $forecasts[$i]->temperature));

			// ----------------- DAY ----------------------
			$weekday = date('l', strtotime($forecasts[$i]->forecast_date));
			$days[$i]['day'] = 'other.'.$weekday;

			// ------------------ ICON ---------------------

			//Get the condition string
	        $condition = Conditions::find($forecasts[$i]->condition_id)->condition;

	        // Decide which icon is picked
	        switch ($condition) {
	            case 'clear_sky':
	                $icon = 'Sun.png';
	                break;
	            case 'few_clouds':
	                $icon = 'MostlyCloudy.png';
	                break;
	            case 'scattered_clouds':
	                $icon = 'MostlyCloudy.png';
	                break;
	            case 'broken_clouds':
	                $icon = 'Cloud.png';
	                break;
	            case 'shower_rain':
	                $icon = 'Rain.png';
	                break;
	            case 'rain':
	                $icon = 'Rain.png';
	                break;
	            case 'thunderstorm':
	                $icon = 'Tunder.png';
	                break;
	            case 'snow':
	                $icon = 'Snow.png';
	                break;
	            case 'mist':
	                $icon = 'Fogg.png';
	                break;
	            default:
	                $icon = 'Cloud.png';
	                break;
	        }

	        $days[$i]['icon'] = $icon;

	        //----------------- WeatherGuy -----------------------

			//Get the decision tree and process the needed clothes
	        $treeController = new TreeController();
	        $treeController->loadTrees();
	        $reading = $treeController->transformReading($forecasts[$i]);
	        $output = $treeController->classifyReading($reading);

	        //We could not figure out something, fallback
	        if (in_array(-1, $output))
	        {
	            $view->message = Lang::get('guides.clothes_error');
	            $days[$i]['head'] = 1;
	            $days[$i]['body'] = 3;
	            $days[$i]['pants'] = 1;
	            $days[$i]['boots'] = 1;
	        }
	        else
	        {
	            $days[$i]['head'] = $output[0];
	            $days[$i]['body'] = $output[1];
	            $days[$i]['pants'] = $output[2];
	            $days[$i]['boots'] = $output[3];
	        }	        


	        // ------------------ TASKS ----------------------
	        try{

		        $outputTasks = $treeController->classifyTasks($reading);

		        //Deffine posibilities
	            $posibility = array(
	                $outputTasks[0][1],
	                $outputTasks[0][1]+$outputTasks[1][1],
	                $outputTasks[0][1]+$outputTasks[1][1]+$outputTasks[2][1]
	            );

	            // Number of tasks on index page
	            $numberOfTasks = 3;

	            // For each task
	            for($j = 0; $j < $numberOfTasks; $j++){

	                // Generate random value
	                $rand = rand(0,100);
	                $rand = $rand / 100;

	                // Check which type was chosen and get out task
	                if($rand <= $posibility[0]){
	                    $tasks[$j] = getTask($outputTasks[0][0]);
	                }
	                else if($rand <= $posibility[1])
	                {
	                    $tasks[$j] = getTask($outputTasks[1][0]);
	                }
	                else
	                {
	                    $tasks[$j] = getTask($outputTasks[2][0]);
	                }

	                
	                // Prevents picking same task
	                for($k = 0; $k < $j; $k++)
	                {
	                    if($tasks[$j] == $tasks[$k])
	                    {
	                        $j--;
	                    }
	                }
	                
	            }

	            $days[$i]['task1'] = 'activities.' . $tasks[0];
	            $days[$i]['task2'] = 'activities.' . $tasks[1];
	            $days[$i]['task3'] = 'activities.' . $tasks[2];

        	}
			catch (Exception $e)
	        {
	            $days[$i]['task1'] = "activities.error";
	            $days[$i]['task2'] = "activities.error";
	            $days[$i]['task3'] = "activities.error";
	        }  
	        
		}

		$view->days = $days;

		return $view;
	}
}