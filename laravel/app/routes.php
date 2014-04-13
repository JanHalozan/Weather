<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');

//Added for debugging fetcher - remove it when done
Route::get('/fetcher', function()
{
    return View::make('fetcher');
});

/*
Route::get('/', function()
{
	return View::make('hello');
});
*/