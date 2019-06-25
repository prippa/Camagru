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
            if (User::insertNewUser($_POST))
            {
                echo "OK";
                return ;
            }
        }
        Lib::renderPage(
            'Register',
            [BOOTSTRAP, CSS . 'style.css', CSS . 'register_and_login.css'],
            [JS . 'register_and_login.js'],
            VIEWS . 'register.php'
        );
    }

    public function actionLogin()
    {
        Lib::renderPage(
            'Login',
            [BOOTSTRAP, CSS . 'style.css', CSS . 'register_and_login.css'],
            [JS . 'register_and_login.js'],
            VIEWS . 'login.php'
        );
    }

    public function actionLogout()
    {
        echo 'actionLogout';
    }
}
