<?php
class TasksController extends BaseController
{
    function index()
    {
        $view = View::make('tasks');

        $view->tasks = Activities::all();

        return $view;
    }

    function addTask()
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