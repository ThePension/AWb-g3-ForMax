<?php

class UserController
{
    public function showLoginView()
    {
        // TODO
    }

    public function login()
    {
        // TODO
    }

    public function logout()
    {
        // TODO
    }

    public function showRegisterView()
    {
        Helper::view("register");
    }

    public function register()
    {
        // TODO
    }

    public function account()
    {
        // TODO
        
        return Helper::view("account");
    }
}