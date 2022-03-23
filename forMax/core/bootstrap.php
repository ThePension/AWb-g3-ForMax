<?php
require 'core/database/Connection.php';
require 'core/Router.php';
require 'core/Request.php';
require 'core/App.php';
require 'helpers/Helper.php';
require 'core/database/Model.php';

App::load_config("config.php");

App::set('dbh', Connection::make(App::get('config')['database']));
