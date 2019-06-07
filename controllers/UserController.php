<?php

namespace app\controllers;

use app\components\lib\RenderPage;

class UserController
{
    public function actionRegister()
    {
        $rp = new RenderPage(
            'Register',
            [BOOTSTRAP, CSS . 'style.css'],
            VIEWS . 'register.php'
        );
        $rp->render();
    }

    public function actionLogin()
    {
        $rp = new RenderPage(
            'Login',
            [BOOTSTRAP, CSS . 'style.css', CSS . 'login.css'],
            VIEWS . 'login.php'
        );
        $rp->render();
    }

    public function actionLogout()
    {
        echo 'actionLogout';
    }
}
