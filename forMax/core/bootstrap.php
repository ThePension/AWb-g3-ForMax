<?php
session_start();
error_reporting(0);

require 'core/database/Connection.php';
require 'core/Router.php';
require 'core/Request.php';
require 'core/App.php';
require 'helpers/Helper.php';
require 'core/database/Model.php';

require "app/models/Comment.php";
require "app/models/Topic.php";
require "app/models/User.php";
require "app/models/Like.php";

App::load_config("config.php");

App::set('dbh', Connection::make(App::get('config')['database']));
