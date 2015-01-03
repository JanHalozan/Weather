<?php

class GraphicsController extends BaseController 
{
    //This is the default action
    public function index()
    {
    	$view = View::make('graphics');
    	return $view;
    }
}