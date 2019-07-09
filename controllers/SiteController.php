<?php

namespace app\controllers;

use app\components\lib\Lib;

class SiteController
{
    public function actionIndex()
    {
        Lib::renderPage('Main', 'views/index.php');
    }
}
