@extends('layouts.master')

@section('head')
	{{HTML::style('css/tasks-generator.css')}}
@stop

@section('content')

	<form method="post">

		<table>
			<tr>
				<td>
					<span><b>Condition:</b></span>
				</td>

				<td>
					<input type="radio" name="condition" value="clear_sky">Clear |
				</td>

				<td>
					<input type="radio" name="condition" value="scattered_clouds">Clouds |
				</td>

				<td>
					<input type="radio" name="condition" value="rain">Rain |
				</td>

				<td>
					<input type="radio" name="condition" value="snow">Snow 
				</td>
			</tr>			
		</table>

		<br>

		<table>
			<tr>

				<td>
					<input type="number" name="minT" min="-60" max="60" placeholder="T MIN">
				</td>
				
				<td>
					<input type="number" name="maxT" min="-50" max="70" placeholder="T MAX">
				</td>

			</tr>

			<tr>

				<td>
					<select name="activity1">
						<option value="1">type 1</option>
						<option value="2">type 2</option>
						<option value="3">type 3</option>
						<option value="4">type 4</option>
						<option value="5">type 5</option>
					</select>
				</td>
					
				<td>
					<input type="number" name="quantity1" min="1" max="100" placeholder="%">
				</td>
			</tr>

			<tr>

				<td>
					<select name="activity2">
						<option value="1">type 1</option>
						<option value="2">type 2</option>
						<option value="3">type 3</option>
						<option value="4">type 4</option>
						<option value="5">type 5</option>
					</select>
				</td>
					
				<td>
					<input type="number" name="quantity2" min="1" max="100" placeholder="%">
				</td>

			</tr>

			<tr>

				<td>
					<select name="activity3">
						<option value="1">type 1</option>
						<option value="2">type 2</option>
						<option value="3">type 3</option>
						<option value="4">type 4</option>
						<option value="5">type 5</option>
					</select>
				</td>
					
				<td>
					<input type="number" name="quantity3" min="1" max="100" placeholder="%">
				</td>

			</tr>

			<tr>

				<td colspan="2">
					<input id="submitButton" type="submit" value="Generate">
				</td>

			</tr>
		</table>
	</form>

	<br>

	<ul><b>TYPE 1:</b> 
		<?php
	 		for($i = 0; $i < count($type1); $i++){
	 			echo "<li>" . trans('activities.'.$type1[$i]->name) . " | </li>";
	 		}
	 	?>
	</ul>

	<br>

	<ul><b>TYPE 2:</b>   
		<?php
	 		for($i = 0; $i < count($type2); $i++){
	 			echo "<li>" . trans('activities.'.$type2[$i]->name) . " | </li>";
	 		}
	 	?>
	</ul>

	<br>

	<ul><b>TYPE 3:</b> 
		<?php
	 		for($i = 0; $i < count($type3); $i++){
	 			echo "<li>" . trans('activities.'.$type3[$i]->name) . " | </li>";
	 		}
	 	?>
	</ul>

	<br>

	<ul><b>TYPE 4:</b>  
		<?php
	 		for($i = 0; $i < count($type4); $i++){
	 			echo "<li>" . trans('activities.'.$type4[$i]->name) . " | </li>";
	 		}
	 	?>
	</ul>

	<br>

	<ul><b>TYPE 5:</b>  
		<?php
	 		for($i = 0; $i < count($type5); $i++){
	 			echo "<li>" . trans('activities.'.$type5[$i]->name) . " | </li>";
	 		}
	 	?>
	</ul>
@stop