<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\View;
use app\models\Photo;

class SiteController
{
    public function actionIndex()
    {
        $posts = Photo::getLast6();
        Lib::debug($posts);
        View::run(View::INDEX, ['posts' => $posts]);
    }
}
