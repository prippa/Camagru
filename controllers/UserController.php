<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\models\User;

class UserController
{
    public function actionRegister()
    {
        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if (User::validate($login, $email, $password, $password_confirm))
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $token = Lib::getUniqueToken($login);

                User::add($login, $email, $password, $token);
                return ;
            }
        }
        Lib::renderPage('Register', 'views/register.php');
    }

    public function actionLogin()
    {
        Lib::renderPage('Login', 'views/login.php');
    }

    public function actionLogout()
    {
        echo 'actionLogout';
    }
}
