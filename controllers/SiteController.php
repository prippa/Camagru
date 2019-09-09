<?php

namespace app\controllers;

use app\components\lib\View;
use app\models\Photo;
use app\models\User;

class SiteController
{
    public function actionIndex()
    {
        $posts = Photo::getLastNPhotos(6);

        View::run(View::INDEX, ['posts' => $posts]);
    }

    public function actionLikeDislikePOST()
    {
        if (empty($_POST))
            View::run(View::ERROR_404);

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $like_status = $_POST['like_status'];

        Photo::like($user_id, $photo_id, $like_status);
    }
}
