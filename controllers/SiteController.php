<?php

namespace app\controllers;

class SiteController
{
    public function actionIndex()
    {
        session_start();
        $_SESSION['aaa'] = '42';
        if ($_SESSION)
            echo 42;
        var_dump($_SESSION);
        require ROOT . 'views/index.php';
    }
}
