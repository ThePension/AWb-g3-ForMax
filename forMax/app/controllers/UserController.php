<?php

class UserController
{
    public function showLoginView()
    {
        Helper::view("login");
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['username']) && isset($_POST['password']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $user = User::fetchUsername($username)[0];

                if(empty($user))
                {
                    $_SESSION['error_title'] = "Unknown username";
                    $_SESSION['error_description'] = "This username doesn't exist.";
                    Helper::redirect(Helper::createUrl("login"));
                }

                if(!password_verify($password, $user->password))
                {
                    $_SESSION['error_title'] = "Wrong password";
                    $_SESSION['error_description'] = "This password doesn't match the username.";
                    Helper::redirect(Helper::createUrl("login"));
                }

                // Login successful
                $_SESSION[User::$UserSessionId] = $user->id;
                $_SESSION[User::$UserAccessLevel] = "logged";
                Helper::redirect(Helper::createUrl("index"));
            }
            else
            {
                $_SESSION['error_title'] = "Login error";
                $_SESSION['error_description'] = "Missing information(s)";
                Helper::redirect(Helper::createUrl("login"));
            }
        }
        else
        {
            Helper::redirect(Helper::createUrl("login"));
        }
    }

    public function guest()
    {
        $_SESSION[User::$UserAccessLevel] = "guest";
        Helper::redirect(Helper::createUrl("index"));
    }

    public function logout()
    {
        if(isset($_SESSION[User::$UserSessionId]))
        {
            unset($_SESSION[User::$UserSessionId]);
        }

        if(isset($_SESSION[User::$UserAccessLevel]))
        {
            unset($_SESSION[User::$UserAccessLevel]);
        }

        if(isset($_SESSION['private_key_validation']))
        {
            unset($_SESSION['private_key_validation']);
        }

        Helper::view("logout");
    }

    public function showRegisterView()
    {
        Helper::view("register");
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_repeat']))
            {
                if($_POST['password'] !== $_POST['password_repeat']) // If passwords don't match
                {
                    $_SESSION['error_title'] = "Password error";
                    $_SESSION['error_description'] = "Passwords don't match";
                    Helper::redirect(Helper::createUrl("register"));
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

                    Helper::redirect(Helper::createUrl("login"));
                }
                catch (Exception $e)
                {
                    if(strpos(strtoupper($e->getMessage()), "DUPLICATE"))
                    {
                        $_SESSION['error_title'] = "Duplicate username";
                        $_SESSION['error_description'] = "This username already exists, please choose another one.";
                        Helper::redirect(Helper::createUrl("register"));
                    }

                    $_SESSION['error_title'] = "Unknown error";
                    $_SESSION['error_description'] = $e->getMessage();
                    Helper::redirect(Helper::createUrl("register"));
                    
                }
            }
            else
            {
                $_SESSION['error_title'] = "Register error";
                $_SESSION['error_description'] = "Missing information(s)";
                Helper::redirect(Helper::createUrl("register"));
            }
        }
        else
        {
            Helper::redirect(Helper::createUrl("register"));
        }
    }

    public function account()
    {
        // TODO
        $user = User::fetchId($_SESSION[User::$UserSessionId]);
        
        return Helper::view("account", [
            'user' => $user
        ]);
    }

    public function accountUpdate()
    {
        // TODO
    }
}