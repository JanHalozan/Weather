@extends('layouts.master')

@section('content')

<h1>Howdy</h1>

@foreach($schedule as $item)
<a href="{{ $item['link'] }}" target="_blank">
    <div>
        <p>{{ $item['name'] }}</p>
        <img src="{{ $item['image'] }}">
    </div>
</a>
@endforeach

@stop