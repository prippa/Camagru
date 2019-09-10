<?php

namespace app\controllers;

use app\components\lib\View;
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
}
