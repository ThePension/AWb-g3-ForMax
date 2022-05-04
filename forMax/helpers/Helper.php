<?php

/**
 *
 */
class Helper
{
    public static function display($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    // dd = display & die
	public static function dd($data)
    {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';

		die();
	}

    public static function view($name, $data = [])
    {
        extract($data); // Importe les variables dans la table des symboles
                        // voir: http://php.net/manual/fr/function.extract.
                        // voir aussi la méthode compact()
        return require "app/views/{$name}.view.php";
    }


    public static function redirect($path)
    {
        header("Location: /{$path}");
        exit();
    }

    public static function userAuthenticated()
    {
        if (App::get('config')['debug_mode']) {
            return true;
        }

        // TODO : ok if the user is logged
        //return isset($_SESSION[User::$UserSessionId]);

        return false;
    }

    public static function routeAuthorized($uri)
    {
        if (App::get('config')['debug_mode']) {
            return true;
        }

        $tempTab = explode("/", $uri);
        $path = end($tempTab);
        reset($tempTab);

        return in_array($path, App::get('config')['routes_authorized'], true);
    }
}
