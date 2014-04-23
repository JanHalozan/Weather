@extends('layouts.master')

@section('header')
<a href="/">
    <h1 id="title">
        Weatherbound
    </h1>
</a>
@stop

@section('content')
<h4>Welcome back</h4>

{{ Form::open(array()) }}

    <h2>Register</h2>

    {{ Form::text('username'); }}

{{ Form::close() }}

@stop