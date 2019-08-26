<?php

namespace app\controllers;

use app\components\lib\View;
use app\models\Photo;

class SiteController
{
    public function actionIndex()
    {
        $posts = Photo::getLastNPhotos(6);

        View::run(View::INDEX, ['posts' => $posts]);
    }
}
