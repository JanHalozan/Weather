<?php

class TasksGeneratorController extends BaseController
{
    function index()
    {
        $view = View::make('tasks_generator');

        try{
            $view->type1 = Activities::where('activity_type',1)->get();
            $view->type2 = Activities::where('activity_type',2)->get();
            $view->type3 = Activities::where('activity_type',3)->get();
            $view->type4 = Activities::where('activity_type',4)->get();
            $view->type5 = Activities::where('activity_type',5)->get();
        } catch(Exception $e) {
            $view->type1 = "activities.error";
            $view->type2 = "activities.error";
            $view->type3 = "activities.error";
            $view->type4 = "activities.error";
            $view->type5 = "activities.error";
        }

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