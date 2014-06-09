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
Route::post('city', 'IndexController@getCity');
Route::get('lang-select/{local_identifier}', 'IndexController@setLang');

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

//Proceed
Route::get('me', function()
{
    if (Auth::check())
        return UsersController::getMe();
    else
        return App::abort(404);
});

Route::post('me', function()
{
	if (Auth::check())
        return UsersController::postMe();
    else
        return App::abort(404);
});

//Add an add city route
Route::get('city-add', 'CityAddController@index');
Route::post('city-add', 'CityAddController@searchCity');
Route::put('city-add', 'CityAddController@addCity');

//Tasks route
Route::get('tasks', function()
{
    if (Auth::check())
        return TasksController::index();
    else
        return App::abort(404);
});

Route::post('tasks', function()
{
    if (Auth::check())
        return TasksController::addTask();
    else
        return App::abort(404);
});

//TasksGenerator route
Route::get('tasks-generator', function()
{
    if (Auth::check())
    {
        if (Auth::user()->is_admin)
            return TasksGeneratorController::index();
        else
           return App::abort(404);
    }
    else
        return App::abort(404);
});


Route::post('tasks-generator', function()
{
    if (Auth::check())
    {
        if (Auth::user()->is_admin)
            return TasksGeneratorController::save();
        else
            return App::abort(404);
    }
    else
        return App::abort(404);
});


//Route for example generator
Route::get('example-generator', function()
{
    if (Auth::check())
    {
        if (Auth::user()->is_admin)
            return ExampleGeneratorController::index();
        else
            return App::abort(404);
    }
    else
        return App::abort(404);
});

Route::post('example-generator', function()
{
    if (Auth::check())
    {
        if (Auth::user()->is_admin)
            return ExampleGeneratorController::saveExample();
        else
            return App::abort(404);
    }
    else
        return App::abort(404);
});
