@extends('layouts.master')

@section('head')

{{ HTML::style('css/user.css') }}
{{ HTML::script('js/city_add.js') }}
<script>{{ Lang::get('cityAdd.javascript_code'); }}</script>

@stop

@section('content')

<h1 id="user-title">Welcome back <b>{{ $user->username }}</b></h1>
<table>
    <tr>
        <td>
            {{ Lang::get('guides.email') }}
        </td>
        <td>
            {{ $user->username }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Lang::get('guides.selected_city') }}
        </td>
        <td>
            <select>
                @foreach($cities as $city)
                <option value="{{ $city->id }}">
                    {{ $city->name }}
                </option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td>
            {{ Lang::get('cityAdd.title'); }}
        </td>
        <td>
            <div id="input_div">
                <input type="text" name="search" id="search" placeholder="London, England" />
                <label id="input_warning">{{ Lang::get('cityAdd.warning'); }}</label><br/>
            </div>
            <div id="show_div">
                <p id="found_city">{{ Lang::get('cityAdd.city_found'); }} <span id="city_name">London, UK</span></p>
                <input type="hidden" name="data" id="data" />
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" id="button_row">
            <button id="save-button" class="green-sea-flat-button">Save</button>
            <button type="button" id="search_button" class="green-sea-flat-button">{{ Lang::get('cityAdd.search'); }}</button>
            <button type="button" id="add_button" class="green-sea-flat-button">{{ Lang::get('cityAdd.add_button'); }}</button>
        </td>
    </tr>
</table>

@stop