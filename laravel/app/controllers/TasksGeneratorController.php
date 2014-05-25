<?php

class TasksGeneratorController extends BaseController
{
    function index()
    {
        $view = View::make('tasks_generator');

        return $view;
    }

    function save()
    {

        if(isset($_POST['activity1']) && isset($_POST['activity2']) && isset($_POST['activity3'])&& isset($_POST['maxT'])&& isset($_POST['maxT'])&& isset($_POST['condition'])){
            
            generate("quantity1","activity1");
            generate("quantity2","activity2");
            generate("quantity3","activity3");

            echo "done";
        }
        else
        {
            echo "Something is not set";
        }
        

        return;
        //return Redirect::to('tasks_generator');
    }

    
}

function generate($quantity, $activity){
        
        $databaseCon = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');

        $minT = $_POST['minT'];
        $maxT = $_POST['maxT'];

        // Increment and decrement min and max temperature until they meet
        // Create example for each temperature created this way
        // Example structure => temperature / condition / activityType
        for($i = 1; $i <= $_POST[$quantity]; $i++) {

            if($i % 2 == 0){
                //Insert
                $query = "INSERT INTO tasks_examples(temperature, weatherCondition, activityType) 
                VALUES ($minT,'".$_POST['condition']."',". $_POST[$activity] .");";

                mysqli_query($databaseCon, $query);

                $minT += 1;
            } 
            else 
            {
                //Insert
                $query = "INSERT INTO tasks_examples(temperature, condition, activityType)
                          VALUES ($maxT,'".$_POST['condition']."',". $_POST[$activity] .");";

                mysqli_query($databaseCon, $query);

                $maxT -= 1;

                if($i % 11 == 0){
                    $minT = $_POST['minT'];
                    $maxT = $_POST['maxT'];
                }
            }
        }

        mysqli_close($databaseCon);
    }