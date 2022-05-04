<?php

require 'core/bootstrap.php';

$uri = Request::uri();

$router = Router::load('routes.php');

if(Helper::userAuthenticated())
{
    $router->direct($uri);
}
else
{
    if(Helper::routeAuthorized($uri))
    {
        $router->direct($uri);
    }
    else
    {
        if(Helper::userIsGuest() && Helper::routeGuestAuthorized($uri))
        {
            $router->direct($uri);
        }
        else
        {
            if(Helper::userIsGuest())
            {
                $path =  App::get('config')['install_prefix'] . '/index';
            }
            else
            {
                $path =  App::get('config')['install_prefix'] . '/login';
            }
            
            Helper::redirect($path);
        }
    }
}

