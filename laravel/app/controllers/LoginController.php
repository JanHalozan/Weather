<?php
/**
 * Created by PhpStorm.
 * User: janhalozan
 * Date: 4/16/14
 * Time: 9:22 AM
 *
 * Route: /login
 * Purpose: logs users in
 *
 */

class LoginController extends BaseController
{
    public function index()
    {
        return View::make('login');
    }
} 