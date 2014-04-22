@extends('layouts.master')

@section('head')
	{{HTML::style('css/index.css')}}
	{{HTML::script('js/index.js')}}
@stop

@section('content')
	<div id="frame">
		<div id="weather-guy">
			
		</div>
		
		<div id="info-panel">
			<div id="first-line">
				<div id="icon">
					
				</div>
				<div id="temperature">
					<p>{{ $temperature }}°</p>
				</div>
			</div>
			
			<div id="second-line">
				<p>Mostly cloudy</p>
			</div>

			<div id="third-line">
				<p>Maribor Slovenia</p>
			</div>
		</div>

		<div id="tasks">
			
		</div>

		<div id="title-fact">
			<p>Did you know?</p>
		</div>

		<div id="fact">
			<p>Humans are the only primates that don’t have pigment in the palms of their hands.</p>
		</div>
	</div>
@stop

