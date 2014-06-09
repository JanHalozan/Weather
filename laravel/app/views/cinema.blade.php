@extends('layouts.master')

@section('head')

{{ HTML::style('css/cinema.css') }}

@stop

@section('content')

<table>
	<tr>
		<th>
			<p>Cover</p>
		</th>
		<th>
			<p>Kratek opis</p>
		</th>
	</tr>
	@foreach($schedule as $item)
	<tr>
	    	<td>
	    		<img src="{{ $item['image'] }}">
	    	</td>
	    	<td>
	    		<div>
	    			<h4>{{ $item['name'] }}</h4>

	    			@if(strlen($item['description']) > 150)
	    				<p>{{ substr($item['description'], 0, 150) }}...</p>
	    			@else
	    				<p>{{ $item['description'] }}</p>
	    			@endif
	    		</div>
	    		<a href="{{ $item['link'] }}" target="_blank"><p class="link">Ogled</p></a>
	    	</td>
	</tr>
	@endforeach
</table>

@stop