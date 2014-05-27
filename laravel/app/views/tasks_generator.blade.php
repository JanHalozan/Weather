@extends('layouts.master')

@section('head')
	
@stop

@section('content')

	<form method="post">

		<input type="number" name="minT" min="-60" max="60">
		<input type="number" name="maxT" min="-50" max="70">
		<input type="radio" name="condition" value="clear">Clear 
		<input type="radio" name="condition" value="cloud">Cloudy 
		<input type="radio" name="condition" value="rain">Rainy 
		<input type="radio" name="condition" value="snow">Snowy 
		<input type="radio" name="condition" value="wind">Windy 
		<br>
		<br>

		<select name="activity1">
			<option value="1">type 1</option>
			<option value="2">type 2</option>
			<option value="3">type 3</option>
		</select>
		<input type="number" name="quantity1" min="1" max="100">
		<br>

		<select name="activity2">
			<option value="1">type 1</option>
			<option value="2">type 2</option>
			<option value="3">type 3</option>
		</select>
		<input type="number" name="quantity2" min="1" max="100">
		<br>

		<select name="activity3">
			<option value="1">type 1</option>
			<option value="2">type 2</option>
			<option value="3">type 3</option>
		</select>
		<input type="number" name="quantity3" min="1" max="100">
		<br>

		<input type="submit" value="Generate">
	</form>

@stop