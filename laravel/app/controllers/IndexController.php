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
        $view = View::make('index');

        //$record = CurrentWeather::where('name', 'like', $place);
        $record = "-40";
        $view->temperature = $record;

        /* Useless Fact parse */
        // Get content of html
        $html = file_get_contents("http://uselessfacts.net/");
        
        // Load that content and create xPath
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xPath = new DomXPath($doc);
        
        // Find all facts on the first page and chose one randomly
       	$temp = $xPath->query("//div[@class='facttext']");
        $factNumber = rand(0, $temp->length-1);

        // Create variable fact which is passed to the view
        $view->fact = $temp->item($factNumber)->nodeValue;
        
        return $view;
    }

}
