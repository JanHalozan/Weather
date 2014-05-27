<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 5/22/14
 * Time: 11:25 AM
 */

//TreeNode structure
class TreeNode
{
    public $split_variable;
    public $split_value;
    public $class;
    public $childs;

    function __construct()
    {
        $this->class = null;
        $this->childs = array();
    }
}

class TreeReading
{
    public $temperature;
    public $humidity;
    public $wind_speed;
    public $cloudiness;
    public $day;
    public $clear;
    public $rain;
    public $snow;
    public $clouds;

    function __construct($t, $h, $w, $c, $d, $clear, $clouds, $rain, $snow)
    {
        $this->temperature = intval($t);
        $this->humidity = intval($h);
        $this->wind_speed = intval($w);
        $this->cloudiness = intval($c);
        $this->day = $d;
        $this->clear = $clear;
        $this->clouds = $clouds;
        $this->rain = $rain;
        $this->snow = $snow;
    }
}

class TreeController
{
    public $head_tree;
    public $torso_tree;
    public $leg_tree;
    public $shoe_tree;

    private $condition_values = array(
        "clear_sky" => array(true, false, false, false),
        "few_clouds" => array(true, true, false, false),
        "scattered_clouds" => array(false, true, false, false),
        "broken_clouds" => array(false, true, false, false),
        "shower_rain" => array(false, true, true, false),
        "rain" => array(false, true, true, false),
        "thunderstorm" => array(false, true, true, false),
        "snow" => array(false, true, false, true),
        "mist" => array(false, true, false, false),
    );

    function __construct()
    {
        $this->head_tree = null;
        $this->torso_tree = null;
        $this->leg_tree = null;
        $this->shoe_tree = null;
    }

    public function loadTrees()
    {
        $decision_trees = DB::table('decision_trees')->get();
        foreach ($decision_trees as $tree)
        {
            if ($tree->part == 'torso')
            {
                $this->torso_tree = unserialize($tree->data);
            }
            elseif ($tree->part == 'head')
            {
                $this->head_tree = unserialize($tree->data);
            }
            elseif ($tree->part == 'legs')
            {
                $this->leg_tree = unserialize($tree->data);
            }
            elseif ($tree->part == 'shoe')
            {
                $this->shoe_tree = unserialize($tree->data);
            }
        }
    }

    //Transforms a CurrentWeather reading into a tree friendly format
    public function transformReading(&$reading)
    {
        //Create TreeReading with values
        $read = new TreeReading($reading->temperature, $reading->humidity, $reading->wind_speed, $reading->cloudiness, $reading->day,
            false, false, false, false);

        //Fetch conditions from DB, and then set boolen TreeReading values according to the condition
        $condition = DB::table('weather_conditions')->where('id', '=', $reading->condition_id)->first();
        $values = $this->condition_values[$condition->condition];
        $read->clear = $values[0];
        $read->clouds = $values[1];
        $read->rain = $values[2];
        $read->snow = $values[3];

        return $read;
    }

    //Takes a tree reading and returns clothing classes for it
    public function classifyReading(&$reading)
    {
        $classes = array();
        //var_dump($reading);
        //echo "<pre>";
        //print_r($this->torso_tree);
        if ($this->head_tree != null)
            array_push($classes, $this->traverseTree($reading, $this->head_tree));
        else array_push($classes, -1);
        if ($this->torso_tree != null)
            array_push($classes, $this->traverseTree($reading, $this->torso_tree));
        else array_push($classes, -1);
        if ($this->leg_tree != null)
            array_push($classes, $this->traverseTree($reading, $this->leg_tree));
        else array_push($classes, -1);
        if ($this->shoe_tree != null)
            array_push($classes, $this->traverseTree($reading, $this->shoe_tree));
        else array_push($classes, -1);
        
        return $classes;
    }

    //Move through the tree to first node with a class and return it
    private function traverseTree(&$reading, &$selected_tree)
    {
        $current_node = $selected_tree;
        while ($current_node->class == null)
        {
            if ($current_node->split_variable == "temperature")
            {
                if ($reading->temperature <= $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "humidity")
            {
                if ($reading->humidity <= $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "wind_speed")
            {
                if ($reading->wind_speed <= $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "cloudiness")
            {
                if ($reading->cloudiness <= $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "day")
            {
                if ($reading->day == $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "clear")
            {
                if ($reading->clear == $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "rain")
            {
                if ($reading->rain == $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "snow")
            {
                if ($reading->snow == $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
            elseif ($current_node->split_variable == "clouds")
            {
                if ($reading->clouds == $current_node->split_value)
                    $current_node = $current_node->childs[0];
                else $current_node = $current_node->childs[1];
            }
        }

        //Random class pick
        //Only one class
        if (count($current_node->class) == 1)
        {
            return $current_node->class[0][0];
        }
        //Random class pick
        else
        {
            $sum = 0.0;
            $rand_value = mt_rand() / mt_getrandmax();
            foreach ($current_node->class as $c)
            {
                $sum += $c[1];
                if ($sum >= $rand_value)
                {
                    return $c[0];
                }
            }
            return  $current_node->class[0][0];
        }

    }
}