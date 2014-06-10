@extends('layouts.master')

@section('head')
	{{HTML::style('css/forecast.css')}}
	{{HTML::script('js/forecast.js')}}
@stop

@section('content')
	<ul id="days-list">
		@foreach($days as $day)
		<li class="days-item">
			<div class="forecast-frame">
				<div class="day">
					<h2>{{ Lang::get($day['day']) }}</h2>
				</div>
				<div class="weather">
					<img class="weather-icon" src="images/{{$day['icon']}}">
					<div class="weather-info">
						<h2>{{ round($day['temperature']) }}°C</h2>
						<span>Hi: {{ round($day['high']) }}°C</span><br>
						<span>Lo: {{ round($day['low']) }}°C</span>
					</div>
					<div style="clear: both;"></div>
				</div>

				<div style="clear: both;"></div>
				<div id="weather-guy">			
					<div id="pants">
						<img src="images/{{ $day['pants'] . '_legs.png' }}"/>
					</div>

					<div id="body">
						<img src="images/{{ $day['body'] . '_torso.png' }}"/>
					</div>

					<div id="head">
						<img src="images/{{ $day['head'] . '_head.png' }}"/>
					</div>

					<div id="boots">
						<img src="images/{{ $day['boots'] . '_boots.png' }}"/>
					</div>

					<img src="images/WeatherGuy.png" alt="Weatherguy"/>
				</div>
				{{-- Only if we're logged in we show the tasks --}}
				@if(Auth::check())
				<div class="tasks">
					<ul class="tasks-list">
						<li>{{ Lang::get($day['task1']) }}</li>
						<li>{{ Lang::get($day['task2']) }}</li>
						<li>{{ Lang::get($day['task3']) }}</li>
					</ul>
				</div>
				@endif
			</div>
		</li>
		@endforeach
		<div style="clear: both;"></div>
	</ul>
@stop