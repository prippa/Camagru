<?php

namespace app\controllers;

use app\components\lib\View;
use app\models\User;

class PhotoController
{
    public function actionMakePhoto()
    {
        User::redirectToLoginCheck();

        View::run(View::MAKE_PHOTO);
    }
}
