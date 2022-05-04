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
        $path =  App::get('config')['install_prefix'] . '/login'; // brut force for now
        Helper::redirect($path);
    }
}

