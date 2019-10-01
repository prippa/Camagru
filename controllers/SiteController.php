<?php

namespace app\controllers;

use app\views\View;
use app\models\Photo;
use app\models\User;

class SiteController
{
    public function actionIndex()
    {
        $photos = Photo::getLastNPhotos(6, User::getId());
        Photo::preparePhotos($photos);

        View::run(View::INDEX, ['photos' => $photos]);
    }
}
