<?php
/**
 * Created by PhpStorm.
 * User: janhalozan
 * Date: 4/15/14
 * Time: 2:37 PM
 *
 * Route: /
 * Model: <none - yet>
 *
 *
 */

class IndexController extends BaseController
{
    //This is the default action
    public function index()
    {
        //Get the user location
        $place = 'Maribor';

        //Populate our view with data for the current city
        $view = View::make('index', array('data' => Index::placeData($place)));


        return $view;
    }
}