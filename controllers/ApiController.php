<?php

namespace app\controllers;

use app\components\lib\Mail;
use app\models\Comment;
use app\models\Like;
use app\models\Photo;
use app\models\User;
use app\core\View;

class ApiController
{
    public function actionLikeDislikePOST()
    {
        if (empty($_POST)) {
            View::run('error_pages/404');
        }

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $like_status = $_POST['like_status'];

        Like::action($user_id, $photo_id, $like_status);

        exit('OK');
    }

    private function sendNotification(int $user_id, int $photo_id): void
    {
        $photo_user_id = Photo::getUserIdById($photo_id);

        if ($user_id != $photo_user_id) {
            $photo_user = User::getUserByID($photo_user_id);

            if ($photo_user['notifications'] === '1') {
                $login = User::getLoginById($user_id);
                $email = $photo_user['email'];
                Mail::notification($login, $email, $photo_id);
            }
        }
    }

    public function actionAddNewComment()
    {
        if (empty($_POST)) {
            View::run('error_pages/404');
        }

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $comment = $_POST['comment'];

        Comment::add($user_id, $photo_id, $comment);

        $this->sendNotification($user_id, $photo_id);

        exit('OK');
    }

    public function actionGetMorePhotos()
    {
        if (empty($_POST)) {
            View::run('error_pages/404');
        }

        $photo_count = $_POST['photo_count'];
        $cycle = $_POST['cycle'];
        $query_type = $_POST['query_type'];

        if ($query_type == '1') {
            $photos = Photo::getLastNPhotos($photo_count, User::getId(), $cycle);
        } else {
            $photos = Photo::getLastNUserPhotos($photo_count, User::getId(), $cycle);
        }

        Photo::preparePhotos($photos);

        echo json_encode($photos);
    }

    public function actionDeletePhotoById()
    {
        if (empty($_POST)) {
            View::run('error_pages/404');
        }

        $id = $_POST['id'];
        $file = Photo::getFileById($id);

        Photo::deleteById($id);
        unlink($file);

        echo 'OK';
    }

    private function uploadImage(string $image): ?string
    {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $data = base64_decode($image);
        $file = UPLOADS . uniqid() . '.png';
        $success = file_put_contents($file, $data);

        return $success ? $file : null;
    }

    public function actionUploadPhotos()
    {
        $image = $_POST['image_base_64'];
        $image_id = $_POST['image_id'];

        $file = $this->uploadImage($image);
        if ($file) {
            Photo::add($file, User::getId());
            echo $image_id;
        } else {
            echo 'KO';
        }
    }
}
