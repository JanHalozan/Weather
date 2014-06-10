@extends('layouts.master')

@section('head')

{{ HTML::style('css/citypicker.css') }}
{{ HTML::script('js/citypicker.js') }}

@stop

@section('content')

<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<div id="main-div">
    <div id="city-picker-div">
        <h1 id="picker-title">{{ Lang::get('other.city_pick_title') }}</h1>
        <div id="maps-div">Google Maps</div>
        <input type="hidden" name="latitude" id="latitude" value="46.55"/>
        <input type="hidden" name="longitude" id="longitude" value="15.63"/>
        <button id="submit-button">{{ Lang::get('other.city_pick_accept') }}</button>
    </div>
    <div id="success-div">
        <h1 id="success-text">{{ Lang::get('other.city_pick_success') }}</h1>
    </div>
</div>

@stop