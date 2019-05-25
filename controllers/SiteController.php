<?php

namespace app\controllers;

class SiteController
{
    public function actionIndex()
    {
        require ROOT . 'views/index.php';
    }
}
