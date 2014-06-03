@extends('layouts.master')

@section('head')

{{ HTML::style('css/citypicker.css') }}
{{ HTML::script('js/citypicker.js') }}

@stop

@section('content')

<select>
    <option>Click to select</option>
    @foreach ($cities as $city)
        <option value="{{ urlencode($city->id) }}">{{ $city->name }}</option>
    @endforeach
</select>

@stop