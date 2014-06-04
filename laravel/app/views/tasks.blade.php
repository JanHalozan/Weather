@extends('layouts.master')

@section('head')
	{{HTML::style('css/tasks.css')}}
	{{HTML::script('js/tasks.js')}}
@stop

@section('content')
	<div class="dayContainer">
		<ul id="c1">
	
		</ul>
	</div>

	<div class="dayContainer">
		<ul id="c2">
	
		</ul>
	</div>

	<div class="dayContainer">
		<ul id="c3">
	
		</ul>
	</div>

	<div class="dayContainer">
		<ul id="c4">
	
		</ul>
	</div>

	<div class="dayContainer">
		<ul id="c5">

		</ul>
	</div>

	<div class="dayContainer r">
		<ul id="c6">

		</ul>
	</div>
	</br>
	
	<select id="comboBox">
		<?php
			for($i = 0; $i < count($tasks); $i++){
				echo "<option value='".$tasks[$i]->activity_type."'>".$tasks[$i]->name."</option>";
			}
		?>
	</select>

	<button id="addButton">Add task</button>	
@stop