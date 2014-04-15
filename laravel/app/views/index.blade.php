@extends('layouts.master')
<!--
* Created by PhpStorm.
* User: janhalozan
* Date: 4/15/14
* Time: 2:53 PM
*
* Index page, built on master template
*
*
*
-->

@section('header')
<a href="/">
    <h1 id="title">
        Weatherbound
    </h1>
</a>
<ul id="navigation">
    <a href="login"><li>Log in</li></a>
    <a href="login"><li>Log in</li></a>
    <a href="login"><li>Log in</li></a>
</ul>
@stop

@section('content')

{{-- This is a blade comment, I will remove it soon, now its here just for the reference --}}
{{-- Here we echo out the data that we got from our controller --}}
{{ $data }}

@stop

@section('footer')
<div id="footer-content">
    <p>
        Copyright &copy; Weatherbound.
    </p>
</div>
@stop

