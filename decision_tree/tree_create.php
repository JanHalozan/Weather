<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 4/29/14
 * Time: 4:31 PM
 */

include_once "information_gain.php";

//Some testing examples with no meaning, just to test tree
$base_examples = array(
    new Example(20, 20, 4, 60, true, true, false, false, false, 1),
    new Example(18, 30, 3, 50, true, false, true, false, false, 2),
    new Example(5, 20, 2, 20, false, true, false, true, false, 3),
    new Example(0, 0, 2, 30, true, false, false, true, false, 4),
    new Example(35, 80, 2, 10, true, false, false, true, true, 5),
    new Example(40, 80, 2, 10, true, false, true, false, false, 5),
);

function findMostCommonClass(&$data_set)
{
    //Count the number of each class
    $class_list = array();
    $class_count = array();
    foreach ($data_set as $d)
    {
        if (!is_integer(array_search($d->class, $class_list)))
        {
            array_push($class_list, $d->class);
            $class_count[strval($d->class)] = 1;
        }
        else
        {
            $class_count[strval($d->class)] += 1;
        }
    }

    //Find the class with highest count
    $max_class = $class_list[0];
    $max_count = $class_count[strval($max_class)];

    foreach ($class_list as $c)
    {
        if ($class_count[strval($c)] > $max_count)
        {
            $max_class = $c;
            $max_count = $class_count[strval($c)];
        }
    }

    return $max_class;
}

function calculateEntropy(&$data_set)
{
    //Create a list of all classes in data set with their count
    $class_list = array();
    $class_count = array();
    $total_count = 0;
    foreach($data_set as $d)
    {
        if (!is_integer(array_search($d->class, $class_list)))
        {
            array_push($class_list, $d->class);
            $class_count[strval($d->class)] = 1;
        }
        else
        {
            $class_count[strval($d->class)] += 1;
        }
        ++$total_count;
    }

    //Calculate entropy
    $entropy = 0;
    foreach ($class_list as $c)
    {
        $proportion = floatval($class_count[strval($c)] / $total_count);
        $entropy -= ($proportion * log($proportion, 2));
    }
    return $entropy;
}

function buildDecisionTree($examples, $attributes)
{
    $node = new TreeNode();

    //Check if there is only one class left in examples
    $class_list = array();
    foreach ($examples as $e)
    {
        if (!is_integer(array_search($e->class, $class_list)))
        {
            array_push($class_list, $e->class);
        }
    }

    if (count($class_list) == 1)
    {
        $node->class = $class_list[0];
        return $node;
    }

    if (count($attributes) == 0)
    {
        $node->class = findMostCommonClass($examples);
        return $node;
    }

    $entropy = calculateEntropy($examples);

    //Get all information gains
    $gain_array = array();
    foreach ($attributes as $a)
    {
        if ($a == "temperature")
        {
            $info = temperatureInformationGain($examples, $entropy);
            array_push($gain_array, array(
                $info[0], "temperature", $info[1]
            ));
        }
        elseif ($a == "day")
        {
            array_push($gain_array, array(
                dayInformationGain($examples, $entropy), "day"
            ));
        }
        elseif ($a == "rain")
        {
            array_push($gain_array, array(
                rainInformationGain($examples, $entropy), "rain"
            ));
        }
    }

    //Pick best attribute
    $best_pick = $gain_array[0];
    foreach ($gain_array as $gain)
    {
        if ($gain[0] > $best_pick[0])
        {
            $best_pick = $gain;
        }
    }

    //Split at the variable and create two subsets of examples
    $node->split_variable = $best_pick[1];
    $first_set = array();
    $second_set = array();
    $split_value = null;
    if ($best_pick[1] == "temperature")
    {
        foreach ($examples as $e) {
            if ($e->temperature <= $best_pick[2])
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = $best_pick[2];
    }
    else if ($best_pick[1] == "day")
    {
        foreach ($examples as $e) {
            if ($e->temperature == true)
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = true;
    }
    else if ($best_pick[1] == "rain")
    {
        foreach ($examples as $e) {
            if ($e->temperature == true)
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = true;
    }
    //Set split value
    $node->split_value = $split_value;

    //Remove picked attribute from list
    $index = array_search($best_pick[1], $attributes);
    unset($attributes[$index]);
    $attributes = array_values($attributes);

    //Create subtree
    if (count($first_set) == 0)
    {
        $left_tree = new TreeNode();
        $left_tree->class = findMostCommonClass($examples);
        array_push($node->childs, $left_tree);
    }
    else
    {
        array_push($node->childs, buildDecisionTree($first_set, $attributes));
    }

    if (count($second_set) == 0)
    {
        $right_tree = new TreeNode();
        $right_tree->class = findMostCommonClass($examples);
        array_push($node->childs, $right_tree);
    }
    else
    {
        array_push($node->childs, buildDecisionTree($second_set, $attributes));
    }

    return $node;
}

$attributes = array(
    "temperature", "day", "rain"
);

$tree_root = buildDecisionTree($base_examples, $attributes);

echo "<pre>";
print_r($tree_root);
