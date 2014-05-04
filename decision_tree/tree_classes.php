<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 5/4/14
 * Time: 1:56 PM
 */

//Classes used for creating decision tree
class Example
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
    public $class;

    function __construct($t, $h, $w, $c, $d, $clear, $clouds, $rain, $snow, $class)
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
        $this->class = intval($class);
    }
}

class TreeNode
{
    public $split_variable;
    public $split_value;
    public $class;
    public $childs;

    function __construct()
    {
        $this->class = -1;
        $this->childs = array();
    }
}