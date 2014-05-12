<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 5/4/14
 * Time: 1:17 PM
 */

include_once "tree_classes.php";

function temperatureInformationGain(&$data_set, $base_entropy)
{
    //Go through all possible temperatures, create two sets at each temperature and save best information gain split
    $temp_split = -30;
    $best_split_temp = -30;
    $best_information_gain = 0;
    for (; $temp_split < 50; ++$temp_split)
    {
        //Split into two sets
        $first_set = array();
        $second_set = array();
        foreach ($data_set as $d)
        {
            if ($d->temperature <= $temp_split)
            {
                array_push($first_set, $d);
            }
            else
            {
                array_push($second_set, $d);
            }
        }
        //Calcualte inforamtion gain
        $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
                ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

        //Check best split
        if ($information_gain > $best_information_gain)
        {
            $best_information_gain = $information_gain;
            $best_split_temp = $temp_split;
        }
    }
    //Return information
    return array(
        $best_information_gain, $best_split_temp
    );
}

function humidityInformationGain(&$data_set, $base_entropy)
{
    //Go through all possible temperatures, create two sets at each temperature and save best information gain split
    $temp_split = 0;
    $best_split_temp = -30;
    $best_information_gain = 0;
    for (; $temp_split <= 100; ++$temp_split)
    {
        //Split into two sets
        $first_set = array();
        $second_set = array();
        foreach ($data_set as $d)
        {
            if ($d->humidity <= $temp_split)
            {
                array_push($first_set, $d);
            }
            else
            {
                array_push($second_set, $d);
            }
        }
        //Calcualte inforamtion gain
        $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
                ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

        //Check best split
        if ($information_gain > $best_information_gain)
        {
            $best_information_gain = $information_gain;
            $best_split_temp = $temp_split;
        }
    }
    //Return information
    return array(
        $best_information_gain, $best_split_temp
    );
}

function windSpeedInformationGain(&$data_set, $base_entropy)
{
    //Go through all possible temperatures, create two sets at each temperature and save best information gain split
    $temp_split = 0;
    $best_split_temp = -30;
    $best_information_gain = 0;
    for (; $temp_split <= 50; ++$temp_split)
    {
        //Split into two sets
        $first_set = array();
        $second_set = array();
        foreach ($data_set as $d)
        {
            if ($d->wind_speed <= $temp_split)
            {
                array_push($first_set, $d);
            }
            else
            {
                array_push($second_set, $d);
            }
        }
        //Calcualte inforamtion gain
        $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
                ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

        //Check best split
        if ($information_gain > $best_information_gain)
        {
            $best_information_gain = $information_gain;
            $best_split_temp = $temp_split;
        }
    }
    //Return information
    return array(
        $best_information_gain, $best_split_temp
    );
}

function cloudinessInformationGain(&$data_set, $base_entropy)
{
    //Go through all possible temperatures, create two sets at each temperature and save best information gain split
    $temp_split = 0;
    $best_split_temp = -30;
    $best_information_gain = 0;
    for (; $temp_split <= 100; ++$temp_split)
    {
        //Split into two sets
        $first_set = array();
        $second_set = array();
        foreach ($data_set as $d)
        {
            if ($d->cloudiness <= $temp_split)
            {
                array_push($first_set, $d);
            }
            else
            {
                array_push($second_set, $d);
            }
        }
        //Calcualte inforamtion gain
        $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
                ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

        //Check best split
        if ($information_gain > $best_information_gain)
        {
            $best_information_gain = $information_gain;
            $best_split_temp = $temp_split;
        }
    }
    //Return information
    return array(
        $best_information_gain, $best_split_temp
    );
}

function dayInformationGain(&$data_set, $base_entropy)
{
    //Split data into two sets based on parameter
    $first_set = array();
    $second_set = array();
    foreach ($data_set as $d)
    {
        if ($d->day == true)
        {
            array_push($first_set, $d);
        }
        else
        {
            array_push($second_set, $d);
        }
    }
    //Calcualte inforamtion gain
    $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
            ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

    return $information_gain;
}

function clearInformationGain(&$data_set, $base_entropy)
{
    //Split data into two sets based on parameter
    $first_set = array();
    $second_set = array();
    foreach ($data_set as $d)
    {
        if ($d->clear == true)
        {
            array_push($first_set, $d);
        }
        else
        {
            array_push($second_set, $d);
        }
    }
    //Calcualte inforamtion gain
    $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
            ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

    return $information_gain;
}

function rainInformationGain(&$data_set, $base_entropy)
{
    //Split data into two sets based on parameter
    $first_set = array();
    $second_set = array();
    foreach ($data_set as $d)
    {
        if ($d->rain == true)
        {
            array_push($first_set, $d);
        }
        else
        {
            array_push($second_set, $d);
        }
    }
    //Calcualte inforamtion gain
    $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
            ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

    return $information_gain;
}

function snowInformationGain(&$data_set, $base_entropy)
{
    //Split data into two sets based on parameter
    $first_set = array();
    $second_set = array();
    foreach ($data_set as $d)
    {
        if ($d->snow == true)
        {
            array_push($first_set, $d);
        }
        else
        {
            array_push($second_set, $d);
        }
    }
    //Calcualte inforamtion gain
    $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
            ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

    return $information_gain;
}

function cloudsInformationGain(&$data_set, $base_entropy)
{
    //Split data into two sets based on parameter
    $first_set = array();
    $second_set = array();
    foreach ($data_set as $d)
    {
        if ($d->clouds == true)
        {
            array_push($first_set, $d);
        }
        else
        {
            array_push($second_set, $d);
        }
    }
    //Calcualte inforamtion gain
    $information_gain = $base_entropy - (((count($first_set)/count($data_set))*calculateEntropy($first_set))+
            ((count($second_set)/count($data_set))*calculateEntropy($second_set)));

    return $information_gain;
}
