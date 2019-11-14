<?php

namespace app\controllers;

use app\models\Photo;
use app\models\User;
use app\core\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return void
     */
    public function actionIndex(): void
    {
        $photos = Photo::getLastNPhotos(6, User::getId());
        Photo::preparePhotos($photos);

        $this->view->run('index', ['photos' => $photos], 'Camagru');
    }
}
