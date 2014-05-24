@extends('layouts.master')

@section('head')

{{HTML::script('js/index.js')}}
{{HTML::style('css/index.css')}}

@stop

@section('content')

<h1>Example generator</h1><br>

<?php

//Generate random latitude and longitude
$lat = rand(-9000,9000) / 100;
$lon = rand(-18000,18000) / 100;

//Api key
$owm_api_key = '65fec2c75fb2d93d3128cf9f7b38b8d0';

//Weather conditions, order is priority, if a read returns more conditions, the topmost is picked
$weather_conditions = array(
    '09' => 'shower_rain',
    '10' => 'rain',
    '11' => 'thunderstorm',
    '13' => 'snow',
    '01' => 'clear_sky',
    '02' => 'few_clouds',
    '03' => 'scattered_clouds',
    '04' => 'broken_clouds',
    '50' => 'mist'
);

//Create curl request
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_TIMEOUT => 5,
    CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lon.'&units=metric&APPID='.$owm_api_key,
    CURLOPT_USERAGENT => 'Weatherbound'
));

//Make request to API
$response = curl_exec($curl);
curl_close($curl);

if ($response)
{
    $json_data = json_decode($response, true);

    if ($json_data && isset($json_data['dt']))
    {
        $temp = $json_data['main']['temp'];
        $press = $json_data['main']['pressure'];
        $humid = $json_data['main']['humidity'];
        $wind_sp = $json_data['wind']['speed'];
        $wind_dir = $json_data['wind']['deg'];
        $cloudiness = $json_data['clouds']['all'];
        $sunrise = date('Y-m-d H:i:s', $json_data['sys']['sunrise']);
        $sunset = date('Y-m-d H:i:s', $json_data['sys']['sunset']);

        //Read all weather conditions
        $weather_conditions_read = array();
        $day = true;
        foreach ($json_data['weather'] as $weather)
        {
            $day = substr($weather['icon'], 2, 1) == 'd'? '1' : '0';
            array_push($weather_conditions_read, substr($weather['icon'], 0, 2));
        }

        foreach ($weather_conditions as $condition_key => $condition_value)
        {
            if (is_integer(array_search($condition_key, $weather_conditions_read)))
            {
                $condition = $condition_value;
                break;
            }
        }

        // prints database string
        //echo " => ".$json_data['weather']['0']['description']." (database string: '".$condition."');
    }
}
?>

<table id="example_table">
    <tr>
        <td>
            <table id="detail_table" style="border-spacing: 15px 0px">
                <tr>
                    <td>City:</td>
                    <td><?php echo $json_data['name'].", ".$json_data['sys']['country']?></td>
                </tr>
                <tr>
                    <td style="vertical-align: top">Condition:</td>
                    <td>
                        <?php echo $json_data['weather']['0']['main']?> <br>
                        <?php echo " => " . $json_data['weather']['0']['description']?> <br>
                        <?php echo " => database: '" . $condition . "'"?>
                    </td>
                </tr>
                <tr><td>Temperature:</td>
                    <td><?php echo round($temp,1)?>°C</td>
                </tr>
                <tr>
                    <td>Pressure:</td>
                    <td><?php echo round($press)?> kPa</td>
                </tr>
                <tr>
                    <td>Humidity:</td>
                    <td><?php echo $humid?></td>
                </tr>
                <tr>
                    <td>Wind speed:</td>
                    <td><?php echo $wind_sp?> meters/second</td>
                </tr>
                <tr>
                    <td>Cloudiness:</td>
                    <td><?php echo $cloudiness?>%</td>
                </tr>
                <tr>
                    <td>Daytime:</td>
                    <td><?php echo $day=='1' ? "Day" : "Night"?></td>
                </tr>
            </table>
        </td>

        <td style='vertical-align: top; padding-left: 25px'>
            <b>Cloth picker</b><br>
            Head:
            <select>
                <option value="hair1">Short hair</option>
                <option value="hair2">Hair2</option>
                <option value="hat">Hat</option>
                <option value="hat-scarf">Hat & scarf</option>
            </select> <br>

            Torso:
            <select>
                <option value="hoodie">Hoodie</option>
                <option value="jacket">Jacket</option>
            </select> <br>

            Legs:
            <select>
                <option value="jeans">Jeans</option>
                <option value="shorts">Shorts</option>
                <option value="swimsuit">Swimsuit</option>
            </select> <br>

            Feet:
            <select>
                <option value="shoes1">Trainers</option>
                <option value="shoes-winter">Winter shoes</option>
            </select> <br>
            <button>Save example</button>
        </td>
    </tr>
</table>

@stop