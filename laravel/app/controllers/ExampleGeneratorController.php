<?php
/**
 * Created by PhpStorm.
 * User: Zoran
 * Date: 5/23/14
 * Time: 10:47 AM
 */

class ExampleGeneratorController extends BaseController
{
    function index()
    {
        $view = View::make('example_generator');
        return $view;
    }
}