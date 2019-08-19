<?php

namespace app\controllers;

use app\components\lib\View;

class SiteController
{
    public function actionIndex()
    {
        View::run();
    }
}
