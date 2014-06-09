@extends('layouts.master')

@section('head')

    {{HTML::style('css/login.css')}}

@stop

@section('content')
<h4 id="login-title">{{ Lang::get('login.title'); }}</h4>
<form method="post" action="/login">
    <table>
        @if(isset($error))
            <label class="error">
                {{ $error }}
            </label>
        @endif
        <tr>
            <td>
                <input type="text" name="username" placeholder="{{ Lang::get('login.username') }}">
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" name="password" placeholder="{{ Lang::get('login.password') }}">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="submit" value="{{ Lang::get('login.button') }}">
            </td>
        </tr>
    </table>
</form>

@stop