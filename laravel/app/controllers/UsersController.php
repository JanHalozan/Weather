<?php

class UsersController extends BaseController
{
    public function getLogin()
    {
        return View::make('login');
    }

    public function postLogin()
    {
        if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
        {
            App::setLocale(Auth::user()->locale);

            return Redirect::intended();
        }
        else
        {
            return View::make('login')->with('error', Lang::get('login.incorrect_credentials'));
        }
    }

    public function getRegister()
    {
        return View::make('register');
    }

    public function postRegister()
    {
        //Make a validator out of the rules for our user model
        $validator = Validator::make(Input::all(), User::$rules);

        //If the validation passes create a new user and save it
        if ($validator->passes())
        {
            $user = new User();
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('password'));
            $user->locale = Input::get('locale');

            if (Input::hasFile('avatar'))
            {
                //TODO implement avatar saving
            }

            $user->save();

            //Manually log the user in
            Auth::login($user);

            //Set the locale
            App::setLocale($user->locale);

            //Redirect him to the index page
            return Redirect::intended()->with('message', Lang::get('register.confirm'));
        }
        else
        {
            return View::make('register')->with('errors', $validator->errors());
        }
    }
} 