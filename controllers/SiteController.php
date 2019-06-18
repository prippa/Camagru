<?php

namespace app\controllers;

use app\components\lib\Lib;

class SiteController
{
    public function actionIndex()
    {
        Lib::renderPage(
            'Main',
            [BOOTSTRAP, CSS . 'style.css'],
            VIEWS . 'index.php'
        );
    }
}
