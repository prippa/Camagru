<?php

namespace app\controllers;

use app\components\lib\View;
use app\models\Photo;
use app\models\User;
use DateTime;

class SiteController
{
    public function actionIndex()
    {
        $photos = Photo::getLastNPhotos(6, User::getId());

        foreach ($photos as &$photo)
        {
            $photo['create_date'] = (new DateTime($photo['create_date']))->format('d M Y H:i');
            $photo['link'] = "photo/{$photo['id']}";
        }

        View::run(View::INDEX, ['photos' => $photos]);
    }
}
