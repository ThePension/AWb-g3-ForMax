<?php

require 'core/bootstrap.php';

$uri = Request::uri();

$router = Router::load('routes.php');

$router->direct($uri);
