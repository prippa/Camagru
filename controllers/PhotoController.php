<?php

namespace app\controllers;

use app\models\SuperImages;
use app\core\View;
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

        View::run('make_photo', ['super_images' => $super_images]);
    }

    public function actionSinglePhoto(int $id)
    {
        $photo = Photo::getPhotoById($id, User::getId());

        if (!$photo) {
            View::run('error_pages/404');
        }

        $photo['comments'] = Comment::getAllCommentsByPhotoId($id);

        View::run('single_photo', ['photo' => $photo]);
    }
}
