<?php

namespace app\controllers;

use app\views\View;
use app\models\Comment;
use app\models\Photo;
use app\models\User;

class PhotoController
{
    public function actionMakePhoto()
    {
        User::redirectToLoginCheck();

        View::run(View::MAKE_PHOTO);
    }

    public function actionSinglePhoto(int $id)
    {
        $photo = Photo::getPhotoById($id, User::getId());

        if (!$photo) {
            View::run(View::ERROR_404);
        }

        $photo['comments'] = Comment::getAllCommentsByPhotoId($id);

        View::run(View::SINGLE_PHOTO, ['photo' => $photo]);
    }
}
