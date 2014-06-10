@extends('layouts.master')

@section('head')

{{ HTML::style('css/cinema.css') }}
{{ HTML::script('js/cinema.js') }}

@stop

@section('content')

<h1 id="cinema-title">Spisek aktualnih filmov v kinematografu Cineplexx</h1>
<table>
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
            <a class="ref" href="{{ $item['link'] }}" target="_blank"></a>
        </td>
	</tr>
	@endforeach
</table>

@stop