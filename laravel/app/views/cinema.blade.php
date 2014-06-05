@extends('layouts.master')

@section('content')

<table>
	@foreach($schedule as $item)
	<tr>
		<a href="{{ $item['link'] }}" target="_blank">
	    	<td>
	    		<img src="{{ $item['image'] }}">
	    	</td>
	    	<td>
	    		<div>
	    			<h4>{{ $item['name'] }}</h4>
	    			<p>{{ $item['description'] }}</p>
	    		</div>
	    	</td>
		</a>
	</tr>
	@endforeach
</table>

@stop