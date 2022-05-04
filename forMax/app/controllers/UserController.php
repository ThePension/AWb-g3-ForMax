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
        $install_prefix = App::get('config')['install_prefix'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_repeat']))
            {
                if($_POST['password'] === $_POST['password_repeat']) // If passwords are the same
                {

                }
                else // Passwords don't match
                {
                    $_SESSION['error_title'] = "Password error";
                    $_SESSION['error_description'] = "Passwords don't match";
                    Helper::redirect($install_prefix . "/register");
                }

                $user = new User();

                $user->username = $_POST['username'];
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Based on https://www.php.net/manual/fr/function.password-hash.php

                $user->description = "Empty description";
                $user->timestamp = date("Y-m-d H:i:s");
                
                // $user->save();
            }
            else
            {
                $_SESSION['error_title'] = "Register error";
                $_SESSION['error_description'] = "Missing information(s)";
                Helper::redirect($install_prefix . "/register");
            }
        }
    }

    public function account()
    {
        // TODO
        
        return Helper::view("account");
    }
}