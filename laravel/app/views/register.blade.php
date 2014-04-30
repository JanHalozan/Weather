@extends('layouts.master')

@section('head')

{{HTML::style('css/register.css')}}

@stop

@section('content')

<h4>{{ Lang::get('register.title') }}</h4>
<form method="post" action="/register">
    <table>
        @if(isset($errors))
            <ul id="errors">
                @foreach($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <tr>
            <td>
                <label>{{ Lang::get('register.username') }}</label>
            </td>
            <td>
                <input type="text" name="username">
            </td>
        </tr>
        <tr>
            <td>
                <label>{{ Lang::get('register.password') }}</label>
            </td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
        <tr>
            <td>
                <label>{{ Lang::get('register.retype') }}</label>
            </td>
            <td>
                <input type="password" name="password_confirmation">
            </td>
        </tr>
        <tr>
            <td>
                <label>{{ Lang::get('register.language') }}</label>
            </td>
            <td>
                <select name="locale">
                    <option value="en">{{ Lang::get('register.languages.en') }}</option>
                    <option value="si">{{ Lang::get('register.languages.si') }}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="{{ Lang::get('register.button') }}">
            </td>
        </tr>
    </table>
</form>

@stop