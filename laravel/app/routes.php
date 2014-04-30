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

//Route the index page to our index controller and run the index action
Route::get('/', 'IndexController@index');

Route::get('cinema', 'CinemaController@index');

//User management logic
Route::get('login', 'UsersController@getLogin');
Route::post('login', 'UsersController@postLogin');

Route::get('register', 'UsersController@getRegister');
Route::post('register', 'UsersController@postRegister');

Route::get('logout', function()
{
    Auth::logout();
    return Redirect::to('/');
});

//Add an add city route
Route::get('city_add', 'CityAddController@index');
Route::post('city_add', 'CityAddController@searchCity');