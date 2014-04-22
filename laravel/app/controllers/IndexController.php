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
    public function index() {
        //Get the user location
        $place = 'Maribor';

        //Populate our view with data for the current city
        $view = View::make('index');

        //$record = CurrentWeather::where('name', 'like', $place);
        $record = "-40";
        $view->temperature = $record;

        //Useless Fact parse        
        $html = file_get_contents("http://uselessfacts.net/");
        
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $xPath = new DomXPath($doc);
       	$temp = $xPath->query("//div[@class='facttext']");

        //print_r($temp);
        
        $view->fact = $temp->item(1)->nodeValue;
        //$view->fact = "nekaj";
        return $view;
    }

}
