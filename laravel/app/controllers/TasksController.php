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


class TasksController extends BaseController
{
    public static function index()
    {
        $view = View::make('tasks');

        //No city to show data for, get him to the 
        if (!Cookie::has('city_id'))
            return Redirect::intended()->with('message', Lang::get('guides.forecast_error'));

        $view = View::make('tasks');

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
            
        }

        $view->days = $days;
        $view->tasks = Activities::all();

        return $view;
    }

    public static function addTask()
    {

        if (Request::ajax())
        {
            if(Cookie::get('city_id') != "")
            {
                $taskType = Input::get('taskType');

                $treeController = new TreeController();
                $treeController->loadTrees();
                $forecast = ForecastWeather::where('city_id', Cookie::get('city_id'))->orderBy('forecast_date')->take(5)->get();
                           
                // For each day
                for($i = 0; $i < count($forecast); $i++)
                {
                    // Get output from tree
                    $weatherInfo = $forecast[$i];
                    $reading = $treeController->transformReading($weatherInfo);
                    $output = $treeController->classifyTasks($reading);

                    // Preset posibility on 0 in case day dont have that taskType
                    $posibility[$i] = 0;

                    // For each element of output
                    for($j = 0; $j < count($output); $j++)
                    {
                        // If task type is same as picked
                        if($output[$j][0] === $taskType)
                        {
                            // Save posibility of that task
                            $posibility[$i] = $output[$j][1];
                            break;
                        }
                    }
                }
                
                // Find index of the bigest posibility
                $maxPosibilityVal = 0;
                // $day = $index
                $day = -1;

                // Find index of the bigest posibility
                for($i = 0; $i < count($posibility); $i++)
                {
                    if($posibility[$i] > $maxPosibilityVal)
                    {
                        // If day allready have 5 tasks its ignored
                        if(Input::get("c".$i."Size") < '5'){
                            $maxPosibilityVal = $posibility[$i];
                            $day = $i;
                        }
                    }
                }

                // If none of the days have that type, we dont recomand it
                if($maxPosibilityVal == 0)
                {
                    // Container 6 is trash
                    $day = 5;
                }
            } 
            else 
            {
                $day = "No city";
            }             
        }    

		return $day;    
    }
}