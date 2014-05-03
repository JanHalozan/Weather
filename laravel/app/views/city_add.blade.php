@extends('layouts.master')

@section('head')

{{HTML::script('js/city_add.js')}}
{{HTML::style('css/city_add.css')}}

@stop

@section('content')

<h1>Input city</h1>

<div id="city_input">
    <div id="input_div">
        <label>Input:</label>
        <input type="text" name="search" id="search" placeholder="London, England" />
        <button type="button" id="search_button">Search city</button>
        <label id="input_warning">Please write the input in format City, Country</label><br/>
    </div>
    <div id="show_div">
        <p id="found_city">Found a city named <span id="city_name">London, UK</span></p>
        <button type="button" id="add_button">Add now</button>
    </div>
</div>

@stop