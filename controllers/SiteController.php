<?php

namespace app\controllers;

use app\components\lib\RenderPage;

class SiteController
{
    public function actionIndex()
    {
        $rp = new RenderPage(
            'Main',
            [BOOTSTRAP, CSS . 'style.css'],
            VIEWS . 'index.php'
        );
        $rp->render();
    }
}
