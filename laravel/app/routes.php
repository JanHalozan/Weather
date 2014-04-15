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

//Route the index page to our index controller
Route::get('/', 'IndexController@index');

//Commented out - was a default example provided by Laravel. I will remove it - Jan
//Route::get('/', 'HomeController@showWelcome');


//This is a test route - not used anymore. I will remove it - Jan
Route::get('/test', function()
{
   return View::make('test');
});