<?php

namespace app\controllers;

use app\models\SuperImages;
use app\models\Comment;
use app\models\Photo;
use app\models\User;
use app\core\Controller;

/**
 * Class PhotoController
 * @package app\controllers
 */
class PhotoController extends Controller
{
    /**
     * @return void
     */
    public function actionMakePhoto(): void
    {
        User::redirectToLoginCheck();

        $super_images = [
            'base' => SuperImages::getImagesByType('base'),
            'frame' => SuperImages::getImagesByType('frame')
        ];

        $this->view->run('make_photo', ['super_images' => $super_images]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function actionSinglePhoto(int $id): void
    {
        $photo = Photo::getPhoto($id, User::getId());

        if (!$photo) {
            $this->view->run('error_pages/404');
        }

        $photo['comments'] = Comment::getAllCommentsByPhotoId($id);

        $this->view->run('single_photo', ['photo' => $photo]);
    }
}
