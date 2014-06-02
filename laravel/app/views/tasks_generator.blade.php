@extends('layouts.master')

@section('head')
	{{HTML::style('css/tasks-generator.css')}}
@stop

@section('content')

	<form method="post">

		<input type="number" name="minT" min="-60" max="60" placeholder="T MIN">
		<input type="number" name="maxT" min="-50" max="70" placeholder="T MAX">
		<br>
		<br>
		<input type="radio" name="condition" value="clear_sky">Clear | 
		<input type="radio" name="condition" value="few_clouds">FewClouds |
		<input type="radio" name="condition" value="scattered_clouds">ScatteredClouds |
		<input type="radio" name="condition" value="rain">Rainy |
		<input type="radio" name="condition" value="snow">Snowy 
		<br>
		<br>

		<select name="activity1">
			<option value="1">type 1</option>
			<option value="2">type 2</option>
			<option value="3">type 3</option>
			<option value="4">type 4</option>
			<option value="5">type 5</option>
		</select>
		<input type="number" name="quantity1" min="1" max="100" placeholder="%">
		<br>

		<select name="activity2">
			<option value="1">type 1</option>
			<option value="2">type 2</option>
			<option value="3">type 3</option>
			<option value="4">type 4</option>
			<option value="5">type 5</option>
		</select>
		<input type="number" name="quantity2" min="1" max="100" placeholder="%">
		<br>

		<select name="activity3">
			<option value="1">type 1</option>
			<option value="2">type 2</option>
			<option value="3">type 3</option>
			<option value="4">type 4</option>
			<option value="5">type 5</option>
		</select>
		<input type="number" name="quantity3" min="1" max="100" placeholder="%">
		<br>
		<br>

		<input type="submit" value="Generate">
		<br>
		<br>

		<table>
			<tr>
				<td>
					<ul>TYPE 1: 
						<?php
					 		for($i = 0; $i < count($type1); $i++){
					 			echo "<li>" . $type1[$i]->name . "</li>";
					 		}
					 	?>
					</ul>
				</td>

				<td>
					<ul>TYPE 2: 
						<?php
					 		for($i = 0; $i < count($type2); $i++){
					 			echo "<li>" . $type2[$i]->name . "</li>";
					 		}
					 	?>
					</ul>
				</td>

				<td>
					<ul>TYPE 3: 
						<?php
					 		for($i = 0; $i < count($type3); $i++){
					 			echo "<li>" . $type3[$i]->name . "</li>";
					 		}
					 	?>
					</ul>
				</td>

				<td>
					<ul>TYPE 4: 
						<?php
					 		for($i = 0; $i < count($type4); $i++){
					 			echo "<li>" . $type4[$i]->name . "</li>";
					 		}
					 	?>
					</ul>
				</td>

				<td>
					<ul>TYPE 5: 
						<?php
					 		for($i = 0; $i < count($type5); $i++){
					 			echo "<li>" . $type5[$i]->name . "</li>";
					 		}
					 	?>
					</ul>
				</td>
			</tr>
		</table>
	</form>
@stop