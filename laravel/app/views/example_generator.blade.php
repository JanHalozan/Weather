@extends('layouts.master')

@section('head')

{{HTML::style('css/example_generator.css')}}

@stop

@section('content')

@if(isset($temp))

<h1>Example generator</h1><br>
<table id="example_table">
    <tr>
        <td style='vertical-align: top; padding-left: 25px'>
            <b>Cloth picker</b> <br>
            <form method="post" action="/example_generator">
                <table id="cloth_picker">
                    <tr>
                        <td>Head:</td>
                        <td>
                            <select name="head">
                                <option value="1">Hair</option>
                                <option value="3">Hat</option>
                                <option value="4">Hat & scarf</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Torso:</td>
                        <td>
                            <select name="torso">
                                <option value="1">T-shirt</option>
                                <option value="2">Hoodie</option>
                                <option value="3">Jacket</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Legs:</td>
                        <td>
                            <select name="legs">
                                <option value="1">Jeans</option>
                                <option value="2">Shorts</option>
                                <option value="3">Swimsuit</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Feet:</td>
                        <td>
                            <select name="feet">
                                <option value="1">Trainers</option>
                                <option value="2">Winter shoes</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button id="submit_button" type="submit">Save example</button></td>
                        <td></td>
                    </tr>
                </table>
                <input type="hidden" name="temperature" value="{{$temp}}"/>
                <input type="hidden" name="pressure" value="{{$press}}"/>
                <input type="hidden" name="condition" value="{{$condition}}"/>
                <input type="hidden" name="humidity" value="{{$humid}}"/>
                <input type="hidden" name="wind_speed" value="{{$wind_sp}}"/>
                <input type="hidden" name="wind_direction" value="{{$wind_dir}}"/>
                <input type="hidden" name="cloudiness" value="{{$cloudiness}}"/>
                <input type="hidden" name="sunrise" value="{{$sunrise}}"/>
                <input type="hidden" name="sunset" value="{{$sunset}}"/>
                <input type="hidden" name="day" value="{{$day}}"/>
            </form>
        </td>
        <td>
            <table id="detail_table" style="border-spacing: 15px 0px">
                <tr>
                    <td>City:</td>
                    <td>{{$json_data['name'].", ".$json_data['sys']['country']}}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top">Condition:</td>
                    <td>
                        {{$json_data['weather']['0']['main']}} <br>
                        {{" => detailed: " . $json_data['weather']['0']['description']}} <br>
                        {{" => database: '" . $condition . "'"}}
                    </td>
                </tr>
                <tr><td>Temperature:</td>
                    <td>{{round($temp,1)}}°C</td>
                </tr>
                <tr>
                    <td>Pressure:</td>
                    <td>{{round($press)}} kPa</td>
                </tr>
                <tr>
                    <td>Humidity:</td>
                    <td>{{$humid}}</td>
                </tr>
                <tr>
                    <td>Wind speed:</td>
                    <td>{{$wind_sp}} meters/second</td>
                </tr>
                <tr>
                    <td>Cloudiness:</td>
                    <td>{{$cloudiness}}%</td>
                </tr>
                <tr>
                    <td>Daytime:</td>
                    <td>{{$day=='1' ? "Day" : "Night"}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@else

<div>Example successfully saved!</div>
<button onclick="location.href='example_generator'">Make another example</button>

@endif
@stop