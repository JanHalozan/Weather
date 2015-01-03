@extends('layouts.master')

@section('head')
	{{HTML::style('css/index.css')}}
	{{HTML::script('js/three.min.js')}}
@stop

@section('content')
	<div id="main_view" style="margin: 0 auto">
		{{HTML::script('js/rg_main.js')}}
	</div>	
@stop

