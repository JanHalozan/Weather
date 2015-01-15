@extends('layouts.master')

@section('head')
	{{HTML::style('css/index.css')}}
	{{HTML::style('css/hud.css')}}
	{{HTML::script('js/graphics/three.min.js')}}
	{{HTML::script('js/graphics/OBJLoader.js')}}
	{{HTML::script('js/graphics/controls/threex.keyboardstate.js')}}
	{{HTML::script('js/graphics/controls/helvetiker_regular.typeface.js')}}
	<script type="text/javascript">
	var data_blob = JSON.parse('{{$data_blob}}');
	</script>
	<style>
  		#startGame {
  			position: fixed;
  			width: 100%;
  			height: 100%;
  			background-color: rgba(128, 128, 128, 0.3);
  			top: 50px;
  			left: 0;
  			z-index: 9999;

  			-webkit-touch-callout: none;
    		-webkit-user-select: none;
    		-khtml-user-select: none;
    		-moz-user-select: none;
    		-ms-user-select: none;
    		user-select: none;

    		cursor: pointer;
  		}

  		#startGame h1 {
  			text-align: center;
  			margin-top: 20%;
  			color: white;
  		}
	</style>
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
		{{HTML::script('js/graphics/zoran_main.js')}}
		<div id="startGame" onclick="startClick()">
			<div></div>
			<h1 id="startText">Click for start / press ESC for exit</h1> 
		</div>
		{{HTML::script('js/graphics/saso_main.js')}}
		{{HTML::script('js/graphics/rg_main.js')}}
	</div>
@stop

