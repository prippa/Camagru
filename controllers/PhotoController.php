<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\View;
use app\models\Comment;
use app\models\Like;
use app\models\Photo;
use app\models\User;

class PhotoController
{
    private function uploadImage(array $image) : string
    {
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $img = uniqid() . "." . $extension;
        move_uploaded_file($image['tmp_name'], UPLOADS_DIR . $img);

        return UPLOADS . $img;
    }

    public function actionMakePhoto()
    {
        User::redirectToLoginCheck();

        $messages = [];

        if (!empty($_FILES))
        {
            $img = $this->uploadImage($_FILES['image']);
            Photo::add($img, User::getId());
            $messages['success'][] = "{$_FILES['image']['name']} was uploaded successful!";
        }
        View::run(View::MAKE_PHOTO, ['messages' => $messages]);
    }

    public function actionLikeDislikePOST()
    {
        if (empty($_POST))
            View::run(View::ERROR_404);

        if (!User::isLogged())
            exit('redirect');

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $like_status = $_POST['like_status'];

        Like::action($user_id, $photo_id, $like_status);

        exit('OK');
    }

    public function actionAddNewComment()
    {
        if (empty($_POST))
            View::run(View::ERROR_404);

        if (!User::isLogged())
            exit('redirect');

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $comment = $_POST['comment'];

        Comment::add($user_id, $photo_id, $comment);

//        $photo_user_id = Photo::getUserIdById($photo_id);
//
//        if ($user_id != $photo_user_id)
//            ;

        exit('OK');
    }

    public function actionSinglePhoto(int $id)
    {
        $photo = Photo::getPhotoById($id);

        if (!$photo)
            View::run(View::ERROR_404);

        $photo['comments'] = Comment::getAllCommentsByPhotoId($id);
        View::run(View::SINGLE_PHOTO, ['photo' => $photo]);
    }
}
