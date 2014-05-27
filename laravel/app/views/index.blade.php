@extends('layouts.master')

@section('head')
	{{HTML::style('css/index.css')}}
	{{HTML::script('js/index.js')}}
@stop

@section('content')
	<div id="frame">
		<div id="weather-guy">			
			<div id="pants">
				<img src="images/{{ $pants . '_pants.png' }}"/>
			</div>

			<div id="body">
				<img src="images/{{ $body . '_body.png' }}"/>
			</div>

			<div id="head">
				<img src="images/{{ $head . '_head.png' }}"/>
			</div>

			<div id="boots">
				<img src="images/{{ $boots . '_boots.png' }}"/>
			</div>

			<img src="images/WeatherGuy.png" alt="Weatherguy"/>
		</div>
		
		<div id="info-panel">
			<div id="first-line">
				<div id="icon">
					<img src="images/Cloudy.png" alt="Cloudy"/>
				</div>
				<div id="temperature">
					<p>{{ round($temperature) }}°</p>
				</div>
			</div>
			
			<div id="second-line">
				<p>{{ $condition }}</p>
			</div>

			<div id="third-line">
				<p>
                    @if (isset($countryName))
                        {{ $cityName }}, {{ $countryName }}
                    @else
                        {{ $cityName }}
                    @endif
                </p>
			</div>
		</div>

		<div id="tasks">
			
		</div>

		<div id="title-fact">
			<hr/>
			<p>Did you know?</p>
		</div>

		<div id="fact">
			<p>{{ $fact }}</p>
		</div>
	</div>
@stop

