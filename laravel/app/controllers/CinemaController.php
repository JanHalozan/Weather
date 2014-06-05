<?php

class CinemaController extends BaseController
{
    function index()
    {
        $view = View::make('cinema');

        //Parse the todays cinema schedule
        $html = file_get_contents('http://www.cineplexx.si/main-navigation/spored/');
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");

        $schedule = array();

        $dom = new DOMDocument('1.0', 'utf-8');
        @$dom->loadHTML($html);

        $xPath = new DomXPath($dom);

        $names = $xPath->query("//div[@class='overview-element separator']/div/div/div/h2/a");
        $images = $xPath->query("//div[@class='overview-element separator']/div/div/div/a/img/@data-original");
        $links = $xPath->query("//div[@class='overview-element separator']/div/div/div/a/@href");
        $descriptions = $xPath->query("//div[@class='overview-element separator']/div/div[2]/p");

        for ($i = 0; $i < min($names->length, $images->length, $links->length); $i++)
        {
            $desc = preg_replace("@\<\s*span.*<\s*/\s*span\s*>@i", "", $descriptions->item($i)->nodeValue);
            array_push($schedule, array('name' => $names->item($i)->nodeValue, 'image' => $images->item($i)->nodeValue, 'link' => $links->item($i)->nodeValue, 'description' => $desc));
        }

        $view->schedule = $schedule;

        return $view;
    }
} 