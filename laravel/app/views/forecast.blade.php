@extends('layouts.master')

@section('head')
	{{HTML::style('css/forecast.css')}}
@stop

@section('content')
	<ul>
		@foreach($days as $day)

		<li>
			<div class="forecast-frame">

				<div class="weather">
					<img class="weather-icon" src="">
					<h2>{{ $day['avg'] }}</h2>
					<span>Hi: {{ $day['high'] }}</span>
					<span>Lo: {{ $day['low'] }}</span>
				</div>
				<div class="clothes">
					{{-- TODO implement the dude --}}
				</div>

				{{--Only if we're logged in we show the tasks --}}
				@if(Auth::check())
				<div class="tasks">
					<ul>
						<li>{{ $day['task1'] }}</li>
						<li>{{ $day['task2'] }}</li>
						<li>{{ $day['task3'] }}</li>
					</ul>
				</div>
				@endif
			</div>
		</li>

		@endforeach
	</ul>
@stop