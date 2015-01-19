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

class GraphicsController extends BaseController 
{
    //This is the default action
    public function index()
    {
    	$view = View::make('graphics');

    	//Get weather data
        //Get citie
        if (Cookie::get('city_id'))
        {
            $city = Cities::find(Cookie::get('city_id'));
        }
        else //There is no city in the cookie yet, get an approximate user location
        {
            $ip = $_SERVER['REMOTE_ADDR'];
            
            $url = "https://freegeoip.net/xml/" . $ip;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds

            $response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($status == 200)
            {
                $dom = new DOMDocument('1.0', 'utf-8');
                $dom->loadXML($response);

                $xPath = new DOMXPath($dom);

                //Check if we have an entry for the city name
                $cityName = $xPath->query('//City')->item(0)->textContent;

                $city = Cities::where('name', $cityName)->first();

                //TODO check if where actually returns null
                if (!isset($city))
                {
                    $lat = $xPath->query('//Latitude')->item(0)->textContent;
                    $lon = $xPath->query('//Longitude')->item(0)->textContent;

                    $city = Cities::findNearest($lat, $lon);
                }

                Cookie::queue('city_id', $city->id, 60 * 24 * 3000);
            }
            else
            {
                $view->message = "We were unable to find a nearby location, using Ljubljana as a fallback.";

                $city = Cities::where('name', 'Ljubljana')->first();
            }
        }

        $weatherInfo = CurrentWeather::where('city_id', '=', $city->id)->orderBy('reading_time', 'desc')->firstOrFail();

        //Data for JS
        $data = array();
        $data['temperature'] = $weatherInfo->temperature;
        $data['city_name'] = $city->name;

        //Get the condition string
        $condition = Conditions::find($weatherInfo->condition_id)->condition;
        $data['condition'] = Lang::get('conditions.' . $condition);
        $data['condition_code'] = $condition;

        //Get country data
        $country = Countries::find($city->country_id);
        $data['country'] = $country->name;

        //Get the decision tree and process the needed clothes
        $treeController = new TreeController();
        $treeController->loadTrees();
        $reading = $treeController->transformReading($weatherInfo);
        $output = $treeController->classifyReading($reading);

        //We could not figure out something, fallback
        if (in_array(-1, $output))
        {
            $data['head'] = 1;
            $data['body']= 3;
            $data['pants'] = 1;
            $data['boots'] = 1;
        }
        else
        {
            $data['head'] = $output[0];
            $data['body'] = $output[1];
            $data['pants'] = $output[2];
            $data['boots'] = $output[3];
        }

        //Get tasks
        $outputTasks = $treeController->classifyTasks($reading);

        try
        {
            //Get some tasks suitable

            //Deffine posibilities
            $posibility = array(
                $outputTasks[0][1],
                $outputTasks[0][1]+$outputTasks[1][1],
                $outputTasks[0][1]+$outputTasks[1][1]+$outputTasks[2][1]
            );
            
            // Number of tasks on index page
            $numberOfTasks = 3;

            // For each task
            for($i = 0; $i < $numberOfTasks; $i++){

                // Generate random value
                $rand = rand(0,100);
                $rand = $rand / 100;

                // Check which type was chosen and get out task
                if($rand <= $posibility[0]){
                    $tasks[$i] = getTask($outputTasks[0][0]);
                }
                else if($rand <= $posibility[1])
                {
                    $tasks[$i] = getTask($outputTasks[1][0]);
                }
                else
                {
                    $tasks[$i] = getTask($outputTasks[2][0]);
                }

                
                // Prevents picking same task
                for($j = 0; $j < $i; $j++)
                {
                    if($tasks[$i] == $tasks[$j])
                    {
                        $i--;
                    }
                }
                
            }
            
            $data['task1'] = Lang::get('activities.' . $tasks[0]);
            $data['task2'] = Lang::get('activities.' . $tasks[1]);
            $data['task3'] = Lang::get('activities.' . $tasks[2]);
            
        }
        catch (Exception $e)
        {
            $data['task1'] = Lang::get("activities.error");
            $data['task2'] = Lang::get("activities.error");
            $data['task3'] = Lang::get("activities.error");;
        }       

        $data['task_title'] = Lang::get('other.tasks_recommendation');
        
        //Generate JS data blob for HUD usage
        $view->data_blob = json_encode($data);

    	return $view;
    }
}