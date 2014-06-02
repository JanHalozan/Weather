@extends('layouts.master')

@section('head')

{{HTML::style('css/example_generator.css')}}
{{HTML::script('js/example_generator.js')}}

@stop

@section('content')

@if(isset($temp))

<div id="main_div">
    <h1>Example generator</h1><br>
    <table id="example_table">
        <tr>
            <td>
                <div id="weather-guy">
                    <span class="caption">Preview</span>
                    <div id="legs">
                        <img id="legsImg" src="images/1_legs.png"/>
                    </div>

                    <div id="torso">
                        <img id="torsoImg" src="images/1_torso.png"/>
                    </div>

                    <div id="head">
                        <img id="headImg" src="images/1_head.png"/>
                    </div>

                    <div id="boots">
                        <img id="bootsImg" src="images/1_boots.png"/>
                    </div>

                    <img src="images/WeatherGuy.png" alt="Weatherguy"/>
                </div>
            </td>
            <td style='vertical-align: top; padding-left: 25px'>
                <span class="caption">Cloth picker</span> <br>
                <form method="post" action="/example-generator">
                    <table id="cloth_picker">
                        <tr>
                            <td>Head:</td>
                            <td>
                                <select name="head" onchange="onClothChanged('head')">
                                    <option value="1">Hair</option>
                                    <option value="3">Hat</option>
                                    <option value="4">Hat & scarf</option>
                                    <option value="5">Umbrella</option>
                                    <option value="6">Cap</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Torso:</td>
                            <td>
                                <select name="torso" onchange="onClothChanged('torso')">
                                    <option value="1">T-shirt</option>
                                    <option value="2">Hoodie</option>
                                    <option value="3">Jacket</option>
                                    <option value="4">Raincoat</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Legs:</td>
                            <td>
                                <select name="legs" onchange="onClothChanged('legs')">
                                    <option value="1">Jeans</option>
                                    <option value="2">Shorts</option>
                                    <option value="3">Swim Shorts</option>
                                    <option value="4">Trousers</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Feet:</td>
                            <td>
                                <select name="boots" onchange="onClothChanged('boots')">
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
                <span class="caption">Weather details</span>
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
</div>

@else

<div>Example successfully saved!</div>
<button onclick="location.href='/example-generator'">Make another example</button>

@endif
@stop