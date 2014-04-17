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
				
			</div>

			<div id="third-line">
				
			</div>
		</div>

		<div id="tasks">
			
		</div>
	</div>
@stop

