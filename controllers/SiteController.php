<?php

namespace app\controllers;

use app\models\Photo;
use app\models\User;
use app\core\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $photos = Photo::getLastNPhotos(6, User::getId());
        Photo::preparePhotos($photos);

        $this->view->run('index', ['photos' => $photos], 'Camagru');
    }
}
