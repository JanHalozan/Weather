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
    new Example(5, 20, 2, 20, true, true, false, true, false, 3),
    new Example(0, 0, 2, 30, false, false, false, false, false, 4),
    new Example(-10, 80, 2, 10, false, false, false, true, true, 5),
    new Example(40, 80, 2, 10, false, false, true, true, false, 5),
);

//Finds most common class in data set
function calculateClasses(&$data_set)
{
    //Count the number of each class and total
    $class_list = array();
    $class_count = array();
    $total = 0;
    foreach ($data_set as $d)
    {
        ++$total;
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

    //Crapsort the classes
    for ($i = 0; $i < count($class_list); ++$i)
    {
        for ($j = $i+1; $j < count($class_list); ++$j)
        {
            if ($class_count[strval($class_list[$j])] > $class_count[strval($class_list[$i])])
            {
                $temp = $class_list[$i];
                $class_list[$i] = $class_list[$j];
                $class_list[$j] = $temp;
            }
        }
    }

    //Generate percentage for each class
    $return_list = array();
    foreach ($class_list as $c)
    {
        array_push($return_list, array($c, doubleval($class_count[strval($c)] / $total)));;
    }
    return $return_list;
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

//Recursive function that build the decision tree based on examples and a list of attributes to be decided upon
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

    //Check if only one class left in examples
    if (count($class_list) == 1)
    {
        $node->class = array(array($class_list[0], 1.0));
        return $node;
    }

    //If no more attributes to split, use the most common class in examples
    if (count($attributes) == 0)
    {
        $node->class = calculateClasses($examples);
        return $node;
    }

    //Current entropy
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
        elseif ($a == "humidity")
        {
            $info = temperatureInformationGain($examples, $entropy);
            array_push($gain_array, array(
                $info[0], "humidity", $info[1]
            ));
        }
        elseif ($a == "wind_speed")
        {
            $info = temperatureInformationGain($examples, $entropy);
            array_push($gain_array, array(
                $info[0], "wind_speed", $info[1]
            ));
        }
        elseif ($a == "cloudiness")
        {
            $info = temperatureInformationGain($examples, $entropy);
            array_push($gain_array, array(
                $info[0], "cloudiness", $info[1]
            ));
        }
        elseif ($a == "day")
        {
            array_push($gain_array, array(
                dayInformationGain($examples, $entropy), "day"
            ));
        }
        elseif ($a == "clear")
        {
            array_push($gain_array, array(
                dayInformationGain($examples, $entropy), "clear"
            ));
        }
        elseif ($a == "rain")
        {
            array_push($gain_array, array(
                rainInformationGain($examples, $entropy), "rain"
            ));
        }
        elseif ($a == "snow")
        {
            array_push($gain_array, array(
                rainInformationGain($examples, $entropy), "snow"
            ));
        }
        elseif ($a == "clouds")
        {
            array_push($gain_array, array(
                rainInformationGain($examples, $entropy), "clouds"
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

    //Split at the best variable and create two subsets of examples
    $node->split_variable = $best_pick[1];
    $first_set = array();
    $second_set = array();
    $split_value = null;
    //All the possible splits
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
    else if ($best_pick[1] == "humidity")
    {
        foreach ($examples as $e) {
            if ($e->humidity <= $best_pick[2])
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = $best_pick[2];
    }
    else if ($best_pick[1] == "wind_speed")
    {
        foreach ($examples as $e) {
            if ($e->wind_speed <= $best_pick[2])
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = $best_pick[2];
    }
    else if ($best_pick[1] == "cloudiness")
    {
        foreach ($examples as $e) {
            if ($e->cloudiness <= $best_pick[2])
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = $best_pick[2];
    }
    else if ($best_pick[1] == "day")
    {
        foreach ($examples as $e) {
            if ($e->day == true)
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = true;
    }
    else if ($best_pick[1] == "clear")
    {
        foreach ($examples as $e) {
            if ($e->clear == true)
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = true;
    }
    else if ($best_pick[1] == "rain")
    {
        foreach ($examples as $e) {
            if ($e->rain == true)
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = true;
    }
    else if ($best_pick[1] == "snow")
    {
        foreach ($examples as $e) {
            if ($e->snow == true)
                array_push($first_set, $e);
            else
                array_push($second_set, $e);
        }
        $split_value = true;
    }
    else if ($best_pick[1] == "clouds")
    {
        foreach ($examples as $e) {
            if ($e->clouds == true)
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
    //If there are no examples in first child, create a leaf
    if (count($first_set) == 0)
    {
        $left_tree = new TreeNode();
        $left_tree->class = calculateClasses($examples);
        array_push($node->childs, $left_tree);
    }
    //or recursively call subtree
    else
    {
        array_push($node->childs, buildDecisionTree($first_set, $attributes));
    }

    //Same for second child
    if (count($second_set) == 0)
    {
        $right_tree = new TreeNode();
        $right_tree->class = calculateClasses($examples);
        array_push($node->childs, $right_tree);
    }
    else
    {
        array_push($node->childs, buildDecisionTree($second_set, $attributes));
    }

    //Return current node
    return $node;
}

//Attributes used for splits
$attributes = array(
    "temperature", "humidity", "wind_speed", "cloudiness", "day", "clear", "rain", "snow", "clouds"
);

//Build tree, then serialize it (to be saved into DB), and prints the data as json for easy reading
$tree_root = buildDecisionTree($base_examples, $attributes);

//This to be put into DB
$data = serialize($tree_root);

//Save tree into database
$database = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');

//Delete old tree and insert new one
mysqli_query($database, "DELETE FROM decision_trees WHERE part = 'torso'");
mysqli_query($database, "INSERT INTO decision_trees(part, data) VALUES('torso', '$data');");

mysqli_close($database);

//echo "<pre>";
//echo json_encode($tree_root, JSON_PRETTY_PRINT);
