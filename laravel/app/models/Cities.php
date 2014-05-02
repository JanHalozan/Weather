<?php


class Cities extends Eloquent
{
    protected  $table = 'cities';

    public static function findNearest($lat, $lon)
    {
        //TODO find the nearest city

        $list = Cities::all();

        foreach ($list as $city)
        {
            
        }

        return null;
    }
} 
