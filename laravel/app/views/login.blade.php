@extends('layouts.master')

@section('head')

    {{HTML::style('css/login.css')}}

@stop

@section('header')
<a href="/">
    <h1 id="title">
        Weatherbound
    </h1>
</a>
@stop

@section('content')
<h4>{{ Lang::get('authentication.login_title'); }}</h4>
<form method="post" action="/login">
    <table>
        @if(isset($error))
            <label class="error">
                {{ $error }}
            </label>
        @endif
        <tr>
            <td>
                <label>{{ Lang::get('login.username') }}</label>
            </td>
            <td>
                <input type="text" name="username">
            </td>
        </tr>
        <tr>
            <td>
                <label>{{ Lang::get('login.password') }}</label>
            </td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="{{ Lang::get('login.button') }}">
            </td>
        </tr>
    </table>
</form>

@stop