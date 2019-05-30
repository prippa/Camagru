<?php

namespace app\controllers;

class UserController
{
    public function actionRegister()
    {
        require ROOT . 'views/register.php';
    }

    public function actionLogin()
    {
        require ROOT . 'views/login.php';
    }

    public function actionLogout()
    {
        echo 'actionLogout';
    }
}
