@extends('layouts.master')

@section('head')

{{HTML::style('css/register.css')}}

@stop

@section('content')

<h4 id="register-title">{{ Lang::get('register.title') }}</h4>
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
                <input type="text" name="username" placeholder="{{ Lang::get('register.username') }}">
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" name="password" placeholder="{{ Lang::get('register.password') }}">
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" name="password_confirmation" placeholder="{{ Lang::get('register.retype') }}">
            </td>
        </tr>
        <tr>
            <td>
                {{-- TODO fix the select so that the first option is unselectable --}}
                <select name="locale">
                    <option>{{ Lang::get('register.language') }}</option>
                    <option value="en">{{ Lang::get('register.languages.en') }}</option>
                    <option value="si">{{ Lang::get('register.languages.si') }}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="submit" value="{{ Lang::get('register.button') }}">
            </td>
        </tr>
    </table>
</form>

@stop