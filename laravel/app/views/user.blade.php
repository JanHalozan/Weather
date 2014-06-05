@extends('layouts.master')

@section('head')

{{ HTML::style('css/user.css') }}

@stop

@section('content')

<h1 id="user-title">Welcome back <b>{{ $user->username }}</b></h1>
<table>
	<tr>
		<td>
			{{ Lang::get('guides.email') }}
		</td>
		<td>
			{{ $user->username }}
		</td>
	</tr>
	<tr>
		<td>
			{{ Lang::get('guides.selected_city') }}
		</td>
		<td>
			<select>
				@foreach($cities as $city)
					<option value="{{ $city->id }}">
						{{ $city->name }}
					</option>
				@endforeach
			</select>
		</td>
	</tr>
</table>

@stop