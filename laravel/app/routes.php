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
Route::get('city', 'IndexController@cityPicker');
Route::put('city', 'IndexController@setCookie');
Route::get('city/{cityName}', 'IndexController@cityWeather');

//Forecast logic
Route::get('forecast', 'ForecastController@index');

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

Route::get('me', function()
{
    if (Auth::check())
        return UsersController::getMe();
    else
        return App::abort(404);
});

//Add an add city route
Route::get('city-add', 'CityAddController@index');
Route::post('city-add', 'CityAddController@searchCity');
Route::put('city-add', 'CityAddController@addCity');

//Tasks route
Route::get('tasks','TasksController@index');
Route::post('tasks','TasksController@addTask');

//TasksGenerator route
Route::get('tasks-generator','TasksGeneratorController@index');
Route::post('tasks-generator','TasksGeneratorController@save');

//Route for example generator
Route::get('example-generator', 'ExampleGeneratorController@index');
Route::post('example-generator', 'ExampleGeneratorController@saveExample');
