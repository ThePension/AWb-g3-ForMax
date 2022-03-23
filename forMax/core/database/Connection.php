<?php

/**
 *
 */
class Connection
{
  public static function make($config)
  {
    try
    {            
      $pdo = new PDO(
        $config['connection'].';port='.$config['port'].';dbname='.$config['dbname'],
        $config['username'],
        $config['password'],
        $config['options']
      );

      return $pdo;
    } catch (PDOException $e)
    {
      print_r($e);
      die('Could not connect');
    }
  }
}
