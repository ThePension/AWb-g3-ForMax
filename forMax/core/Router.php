<?php

class Router
{
  protected $routes = [];

  public function define($routes)
  {
    $this->routes = $routes;
  }

  public function direct($uri)
  {
    // example.com/about/us
    // Remove the parameters
    $uri = parse_url($uri)["path"]; // more info: http://php.net/manual/en/function.parse-url.php

    // remove installation prefix
    if (isset(App::get('config')['install_prefix']))
    {
       if (strncmp($uri,
                 App::get('config')['install_prefix'],
                 strlen(App::get('config')['install_prefix'])) == 0)
       {
        if (!($uri = substr($uri, strlen(App::get('config')['install_prefix']) + 1)))
        {
          $uri = "";
        }
      }
    }

    if(array_key_exists ($uri, $this->routes))
    {
        // En PHP 5.6 et suivants, la liste des arguments peut inclure
        // le mot clé ... pour indiquer que cette fonction accepte un nombre
        // variable d'arguments. Les arguments seront passés dans la variable
        // fournie sous forme d'un tableau
        return $this->callAction(
            ...explode('@', $this->routes[$uri]) // ... splat operator, voir http://php.net/manual/fr/migration56.new-features.php
                                                 // (fonctions variadiques http://php.net/manual/fr/functions.arguments.php#functions.variable-arg-list)
                                                 // explode (split a string by a string): http://php.net/manual/en/function.explode.php
        );
    }

    throw new Exception("Not routes defined for this URI.", 1);

  }

  // call a specific action (method) of a controller
  // if not action is specified, the action index() is called by default
  protected function callAction($controller, $action = 'index')
  {
      require_once ("app/controllers/" . $controller . ".php");
      $control = new $controller;

      if(! method_exists($control, $action))
      {
          throw new Exception(
              "$controller does not respond to the action $action."
          );

      }
      return $control->$action();
  }

  public static function load($file)
  {
    // About 'new static':
    // more info: http://php.net/manual/en/language.oop5.late-static-bindings.php
    // and here: https://stackoverflow.com/questions/15898843/what-means-new-static
    $router = new static;
    require 'app/' . $file;

    return $router;
  }
}
