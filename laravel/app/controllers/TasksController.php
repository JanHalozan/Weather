<?php
class TasksController extends BaseController
{
    function index()
    {
        $view = View::make('tasks');

        return $view;
    }

    function addTask()
    {
    	$task = "0";

        if (Request::ajax())
        {
            $task = Input::get('task');
        }
		
		return $task;    
    }
}