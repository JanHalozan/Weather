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

        if(Input::has('activity1') && Input::has('activity2') && Input::has('activity3') && Input::has('maxT') && Input::has('maxT') && Input::has('condition')){
            
            generate("quantity1","activity1");
            generate("quantity2","activity2");
            generate("quantity3","activity3");

            echo "done";
        }
        else
        {
            echo "Something is not set";
        }

        return Redirect::to('tasks-generator');
    }

    
}

function generate($quantity, $activity){

        $minT = Input::get('minT');
        $maxT = Input::get('maxT');

        // Increment and decrement min and max temperature until they meet
        // Create example for each temperature created this way
        // Example structure => temperature / condition / activityType
        for($i = 1; $i <= Input::get($quantity); $i++) {

            if($i % 2 == 0){
                //Insert
                DB::table('tasks_examples')->insert(
                    array('temperature' => $minT,
                        'weatherCondition' => Input::get('condition'),
                        'activityType' => Input::get($activity)
                    )
                );

                $minT += 1;
            } 
            else 
            {

                //Insert
                DB::table('tasks_examples')->insert(
                    array(
                        'temperature' => $maxT,
                        'weatherCondition' => Input::get('condition'),
                        'activityType' => Input::get($activity)
                         )
                );

                $maxT -= 1;

                if($i % 11 == 0){
                    $minT = Input::get('minT');
                    $maxT = Input::get('maxT');
                }
            }
        }
    }