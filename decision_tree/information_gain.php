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
    $temp_split = -30;
    $best_split_temp = -30;
    $best_information_gain = 0;
    for (; $temp_split < 50; $temp_split += 2)
    {
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

        if ($information_gain > $best_information_gain)
        {
            $best_information_gain = $information_gain;
            $best_split_temp = $temp_split;
        }
    }
    return array(
        $best_information_gain, $best_split_temp
    );
}

function dayInformationGain(&$data_set, $base_entropy)
{
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

function rainInformationGain(&$data_set, $base_entropy)
{
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