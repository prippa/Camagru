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
        $filename = uniqid() . "." . $extension;
        move_uploaded_file($image['tmp_name'], UPLOADS_DIR . $filename);

        return $filename;
    }

    public function actionMakePhoto()
    {
        User::redirectToLoginCheck();

        $messages = [];

        if (!empty($_FILES))
        {
            $filename = $this->uploadImage($_FILES['image']);
            Photo::add($filename, User::getId());
            $messages['success'][] = "{$_FILES['image']['name']} was uploaded successful!";
        }
        View::run(View::MAKE_PHOTO, ['messages' => $messages]);
    }
}
