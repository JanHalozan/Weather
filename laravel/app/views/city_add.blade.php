@extends('layouts.master')

@section('head')

{{HTML::script('js/city_add.js')}}
{{HTML::style('css/city_add.css')}}
<script>{{ Lang::get('cityAdd.javascript_code'); }}</script>

@stop

@section('content')

<h1>{{ Lang::get('cityAdd.title'); }}</h1>

<div id="city_input">
    <div id="input_div">
        <label>{{ Lang::get('cityAdd.city'); }}</label>
        <input type="text" name="search" id="search" placeholder="London, England" />
        <button type="button" id="search_button">{{ Lang::get('cityAdd.search'); }}</button>
        <br/>
        <label id="input_warning">{{ Lang::get('cityAdd.warning'); }}</label><br/>
    </div>
    <div id="show_div">
        <p id="found_city">{{ Lang::get('cityAdd.city_found'); }} <span id="city_name">London, UK</span></p>
        <input type="hidden" name="data" id="data" />
        <button type="button" id="add_button">{{ Lang::get('cityAdd.add_button'); }}</button>
    </div>
</div>

@stop