<?php


class Cities extends Eloquent
{
    protected  $table = 'cities';

    public static function findNearest($lat, $lon)
    {
        //TODO find the nearest city

        $list = Cities::all();

        //Best index
        $currentBest = 0;

        //Distance between the target city and city being searched for
        $distance = sqrt(pow($lat - $list[0]->latitude, 2) + pow($lon - $list[0]->longitude, 2));

        for ($i = 1; $i < count($list); $i++)
        {
            $dist = sqrt(pow($lat - $list[$i]->latitude, 2) + pow($lon - $list[$i]->longitude, 2));
            if ($dist < $distance)
            {
                $currentBest = $i;
                $distance = $dist;

                //This is THE city :)
                if ($dist == 0)
                    break;
            }
        }

        return $list[$currentBest];
    }
} 
