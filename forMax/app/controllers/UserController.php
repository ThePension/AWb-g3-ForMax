<?php

class UserController
{
    public function showLoginView()
    {
        Helper::view("login");
    }

    public function login()
    {
        $install_prefix = App::get('config')['install_prefix'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['username']) && isset($_POST['password']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $user = User::fetchUsername($username);

                if(empty($user))
                {
                    $_SESSION['error_title'] = "Unknown username";
                    $_SESSION['error_description'] = "This username doesn't exist.";
                    Helper::redirect($install_prefix . "/login");
                }

                if(!password_verify($password, $user->password))
                {
                    $_SESSION['error_title'] = "Wrong password";
                    $_SESSION['error_description'] = "This password doesn't match the username.";
                    Helper::redirect($install_prefix . "/login");
                }

                // Login successful
                $_SESSION[User::$UserSessionId] = $user->id;
                Helper::redirect($install_prefix . "/topic_show_all");
            }
            else
            {
                $_SESSION['error_title'] = "Login error";
                $_SESSION['error_description'] = "Missing information(s)";
                Helper::redirect($install_prefix . "/login");
            }
        }
        else
        {
            Helper::redirect($install_prefix . "/login");
        }
    }

    public function logout()
    {
        if(isset($_SESSION[User::$UserSessionId]))
        {
            unset($_SESSION[User::$UserSessionId]);
        }

        $install_prefix = App::get('config')['install_prefix'];
        Helper::redirect($install_prefix . "/login");
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
                if($_POST['password'] !== $_POST['password_repeat']) // If passwords don't match
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

                try
                {
                    $user->save();

                    $_SESSION['message_title'] = "Registration succeeded";
                    $_SESSION['message_description'] = "Your account has been created, please connect.";

                    Helper::redirect($install_prefix . "/login");
                }
                catch (Exception $e)
                {
                    if(strpos(strtoupper($e->getMessage()), "DUPLICATE"))
                    {
                        $_SESSION['error_title'] = "Duplicate username";
                        $_SESSION['error_description'] = "This username already exists, please choose another one.";
                        Helper::redirect($install_prefix . "/register");
                    }

                    $_SESSION['error_title'] = "Unknown error";
                    $_SESSION['error_description'] = $e->getMessage();
                    Helper::redirect($install_prefix . "/register");
                    
                }
            }
            else
            {
                $_SESSION['error_title'] = "Register error";
                $_SESSION['error_description'] = "Missing information(s)";
                Helper::redirect($install_prefix . "/register");
            }
        }
        else
        {
            Helper::redirect($install_prefix . "/register");
        }
    }

    public function account()
    {
        // TODO
        
        return Helper::view("account");
    }
}