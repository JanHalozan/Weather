<?php

function getTask($type)
{
    // Get all tasks with activiti that has requiered posibility
    $tmp = Activities::where('activity_type',$type)->get();
    // Pick one task randomli among those chosen tasks
    $randTask = rand(0, Activities::where('activity_type',$type)->count()-1);

    return $tmp[$randTask]->name;
}

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

                //Check if we have an entry for the city name
                $cityName = $xPath->query('//City')->item(0)->textContent;

                $city = Cities::where('name', $cityName)->first();

                //TODO check if where actually returns null
                if (!$city)
                {
                    $lat = $xPath->query('//Latitude')->item(0)->textContent;
                    $lon = $xPath->query('//Longitude')->item(0)->textContent;

                    $city = Cities::findNearest($lat, $lon);
                }

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
        $weatherInfo = CurrentWeather::where('city_id', '=', $city->id)->orderBy('reading_time', 'desc')->firstOrFail();
        $view->temperature = $weatherInfo->temperature;

        //Get the condition string
        $condition = Conditions::find($weatherInfo->condition_id)->condition;
        $view->condition = Lang::get('conditions.' . $condition);

        //Populate the view with city & country data
        $view->cityName = $city->name;

        $country = Countries::find($city->country_id);
        $view->countryName = $country->name;


        //Get the decision tree and process the needed clothes
        $treeController = new TreeController();
        $treeController->loadTrees();
        $reading = $treeController->transformReading($weatherInfo);
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

        $outputTasks = $treeController->classifyTasks($reading);

        if (in_array(-1, $outputTasks))
        {
            $view->task1 = "Error";
            $view->task2 = "Error";
            $view->task3 = "Error";  
        }
        else
        {
            //Get some tasks suitable

            //Deffine posibilities
            $posibility = array($outputTasks[0][1],$outputTasks[0][1]+$outputTasks[1][1],$outputTasks[0][1]+$outputTasks[1][1]+$outputTasks[2][1]);
            
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
                else if($rand <= $posibility[2])
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
            
            $view->task1 = $tasks[0];
            $view->task2 = $tasks[1];
            $view->task3 = $tasks[2];
        }       

        //Get a fact from our base
        try
        {
            $facts = Facts::all();
            $randomFact = rand(0, count($facts));
            $view->fact = $facts[$randomFact]->fact;
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