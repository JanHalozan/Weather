@extends('layouts.master')

@section('head')
	{{HTML::style('css/index.css')}}
	{{HTML::style('css/hud.css')}}
	{{HTML::script('js/graphics/three.min.js')}}
	{{HTML::script('js/graphics/ObjectLoader.js')}}
	{{HTML::script('js/graphics/controls/threex.keyboardstate.js')}}
	{{HTML::script('js/graphics/controls/helvetiker_regular.typeface.js')}}
	<script type="text/javascript">
	var data_blob = JSON.parse('{{$data_blob}}');
	</script>
@stop

@section('content')
	<div id="main_view">
		<!--HUD ELEMENTS -->
		<span id="hud_location"></span>
		<!--First call main init, where the important stuff is setup, then call each dev's stuff, and finall go into the main loop-->
		{{HTML::script('js/graphics/rg_main_init.js')}}
		{{HTML::script('js/graphics/luka_main.js')}}
		{{HTML::script('js/graphics/jan_main.js')}}
		{{HTML::script('js/graphics/fras_main.js')}}
		{{HTML::script('js/graphics/saso_main.js')}}
		{{HTML::script('js/graphics/zoran_main.js')}}
		{{HTML::script('js/graphics/rg_main.js')}}
	</div>
@stop

