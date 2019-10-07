<?php

namespace app\controllers;

use app\models\SuperImages;
use app\views\View;
use app\models\Comment;
use app\models\Photo;
use app\models\User;

class PhotoController
{
    public function actionMakePhoto()
    {
        User::redirectToLoginCheck();

        $super_images = [
            'base' => SuperImages::getImagesByType('base'),
            'frame' => SuperImages::getImagesByType('frame')
        ];

        View::run(View::MAKE_PHOTO, ['super_images' => $super_images]);
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
