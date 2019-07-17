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
            if (User::validate($_POST))
            {
                User::add($_POST);
                echo "OK";
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
