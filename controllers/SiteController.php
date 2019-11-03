<?php

namespace app\controllers;

use app\core\View;
use app\models\Photo;
use app\models\User;

class SiteController
{
    public function actionIndex()
    {
        $photos = Photo::getLastNPhotos(6, User::getId());
        Photo::preparePhotos($photos);

        View::run('index', ['photos' => $photos], 'Camagru');
    }
}
