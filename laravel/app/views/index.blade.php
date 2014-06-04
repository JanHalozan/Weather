@extends('layouts.master')

@section('head')
	{{HTML::style('css/index.css')}}
	{{HTML::script('js/index.js')}}
@stop

@section('header')
<a href="/">
    <h1 id="title">
        Weatherbound
    </h1>
</a>
<ul id="navigation">
	<a href="forecast"><li>Forecast</li></a>
    @if(Auth::check())
    <a href="me"><li>{{ Auth::user()->username }}</li></a>
    <a href="logout"><li>{{ Lang::get('guides.logout') }}</li></a>
    @else
    <a href="register"><li>{{ Lang::get('guides.register') }}</li></a>
    <a href="login"><li>{{ Lang::get('guides.login') }}</li></a>
    @endif
</ul>
@stop

@section('content')
	<div id="frame">
		<div id="weather-guy">			
			<div id="pants">
				<img src="images/{{ $pants . '_legs.png' }}"/>
			</div>

			<div id="body">
				<img src="images/{{ $body . '_torso.png' }}"/>
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
					<img src="images/{{$icon}}" alt="Cloudy"/>
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
            <h2 id="tasks-title">Today you might:</h2>
			<ul id="tasks-list">
                <li><p>{{ $task1 }}</p></li>
                <li><p>{{ $task2 }}</p></li>
                <li><p>{{ $task3 }}</p></li>
			</ul>
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

