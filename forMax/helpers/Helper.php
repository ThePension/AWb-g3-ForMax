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


}
