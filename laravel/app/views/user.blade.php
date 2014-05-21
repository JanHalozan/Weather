@extends('layouts.master')

@section('head')

{{ HTML::style('css/user.css') }}

@stop

@section('content')

<!--TODO make a user management page-->

<h1>Welcome back {{ Auth::user()->username }}</h1>

@stop