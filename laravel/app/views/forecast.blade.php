@extends('layouts.master')

@section('head')
	{{HTML::style('css/forecast.css')}}
@stop

@section('content')
	<ul id="days-list">
		@foreach($days as $day)
		<li class="days-item">
			<div class="forecast-frame">

				<div class="weather">
					<img class="weather-icon" src="/images/Sun.png">
					<div class="weather-info">
						<h2>{{ round($day['temperature']) }}°C</h2>
						<span>Hi: {{ round($day['high']) }}°C</span><br>
						<span>Lo: {{ round($day['low']) }}°C</span>
					</div>
					<div style="clear: both;"></div>
				</div>
				<div class="weather-guy">
					jaka
					{{-- TODO implement the dude --}}
				</div>
				{{-- Only if we're logged in we show the tasks --}}
				@if(Auth::check())
				<div class="tasks">
					<ul class="tasks-list">
						<li>{{ $day['task1'] }}</li>
						<li>{{ $day['task2'] }}</li>
						<li>{{ $day['task3'] }}</li>
					</ul>
				</div>
				@endif
			</div>
		</li>
		@endforeach
		<div style="clear: both;"></div>
	</ul>
@stop