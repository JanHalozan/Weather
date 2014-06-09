@extends('layouts.master')

@section('head')
	{{HTML::style('css/forecast.css')}}
	{{HTML::script('js/tasks.js')}}
@stop

@section('content')
	<ul id="days-list">
		@for ($i = 0; $i < 5; $i++)
		<li class="days-item">
			<div class="forecast-frame">
				<div class="day">
					<h2>{{ Lang::get($days[$i]['day']) }}</h2>
				</div>
				<div class="weather">
					<img class="weather-icon" src="images/{{$days[$i]['icon']}}">
					<div class="weather-info">
						<h2>{{ round($days[$i]['temperature']) }}°C</h2>
						<span>Hi: {{ round($days[$i]['high']) }}°C</span><br>
						<span>Lo: {{ round($days[$i]['low']) }}°C</span>
					</div>
					<div style="clear: both;"></div>
				</div>

				<div style="clear: both;"></div>
				<div id="weather-guy">			
					<div id="pants">
						<img src="images/{{ $days[$i]['pants'] . '_legs.png' }}"/>
					</div>

					<div id="body">
						<img src="images/{{ $days[$i]['body'] . '_torso.png' }}"/>
					</div>

					<div id="head">
						<img src="images/{{ $days[$i]['head'] . '_head.png' }}"/>
					</div>

					<div id="boots">
						<img src="images/{{ $days[$i]['boots'] . '_boots.png' }}"/>
					</div>

					<img src="images/WeatherGuy.png" alt="Weatherguy"/>
				</div>
				{{-- Only if we're logged in we show the tasks --}}
				@if(Auth::check())
				<div class="tasks">
					<ul class="tasks-list c{{$i+1}}">
					</ul>
				</div>
				@endif
			</div>
		</li>
		@endfor
		<div style="clear: both;"></div>
	</ul>

	<br>
	
	<div id="add">
		<p id="info">&nbsp</p>
		<select id="comboBox">
			<?php
				for($i = 0; $i < count($tasks); $i++){
					echo "<option value='". $tasks[$i]->activity_type ."'>". Lang::get('activities.'.$tasks[$i]->name) ."</option>";
				}
			?>
		</select>

		<button id="addButton">Add task</button>
	</div>	
@stop