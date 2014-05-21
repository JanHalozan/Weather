@extends('layouts.master')

@section('head')
	{{HTML::style('css/tasks.css')}}
	{{HTML::script('js/tasks.js')}}
@stop

@section('content')
	<div class="dayContainer">
		<ul id="monday">
			<li>Ena</li>
			<li>Dva</li>
			<li>Tri</li>	
		</ul>
	</div>
	</br>
	
	<select id="comboBox">
		<option value="0">-</option>
		<option value="1">Go running</option>
		<option value="2">Go jogging</option>
		<option value="3">Take a nap</option>
		<option value="4">Spank Fras</option>
	</select>

	<button id="addButton">Add task</button>	
@stop