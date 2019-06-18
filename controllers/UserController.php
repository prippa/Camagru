<?php

namespace app\controllers;

use app\components\lib\Lib;

class UserController
{
    public function actionRegister()
    {
        Lib::renderPage(
            'Register',
            [BOOTSTRAP, CSS . 'style.css'],
            VIEWS . 'register.php'
        );
    }

    public function actionLogin()
    {
        Lib::renderPage(
            'Login',
            [BOOTSTRAP, CSS . 'style.css', CSS . 'login.css'],
            VIEWS . 'login.php'
        );
    }

    public function actionLogout()
    {
        echo 'actionLogout';
    }
}
