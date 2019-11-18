<?php

namespace app\controllers;

use app\components\lib\Mail;
use app\models\Comment;
use app\models\Like;
use app\models\Photo;
use app\models\User;
use app\core\Controller;

/**
 * Class ApiController
 * @package app\controllers
 */
class ApiController extends Controller
{
    /**
     * @return void
     */
    public function actionLikeDislikePOST(): void
    {
        if (empty($_POST)) {
            $this->view->run('error_pages/404');
        }

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $like_status = $_POST['like_status'];

        Like::make($user_id, $photo_id, $like_status);

        exit('OK');
    }

    /**
     * @param int $user_id
     * @param int $photo_id
     * @return void
     */
    private function sendNotification(int $user_id, int $photo_id): void
    {
        $photo_user_id = Photo::getUserId($photo_id);

        if ($user_id != $photo_user_id) {
            $photo_user = User::getUser($photo_user_id);

            if ($photo_user['notifications'] === '1') {
                $login = User::getLogin($user_id);
                $email = $photo_user['email'];
                Mail::notification($login, $email, $photo_id);
            }
        }
    }

    /**
     * @return void
     */
    public function actionAddNewComment(): void
    {
        if (empty($_POST)) {
            $this->view->run('error_pages/404');
        }

        $user_id = User::getId();
        $photo_id = $_POST['id'];
        $comment = $_POST['comment'];

        Comment::insert($user_id, $photo_id, $comment);

        $this->sendNotification($user_id, $photo_id);

        exit('OK');
    }

    /**
     * @return void
     */
    public function actionGetMorePhotos(): void
    {
        if (empty($_POST)) {
            $this->view->run('error_pages/404');
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

    /**
     * @return void
     */
    public function actionDeletePhotoById(): void
    {
        if (empty($_POST)) {
            $this->view->run('error_pages/404');
        }

        $id = $_POST['id'];
        $file = Photo::getFile($id);

        Photo::delete($id);
        unlink($file);

        echo 'OK';
    }

    /**
     * @param string $image
     * @return string|null
     */
    private function uploadImage(string $image): ?string
    {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $data = base64_decode($image);
        $file = 'uploads/' . uniqid() . '.png';
        $success = file_put_contents($file, $data);

        return $success ? $file : null;
    }

    /**
     * @return void
     */
    public function actionUploadPhotos(): void
    {
        $image = $_POST['image_base_64'];
        $image_id = $_POST['image_id'];

        $file = $this->uploadImage($image);
        if ($file) {
            Photo::insert($file, User::getId());
            echo $image_id;
        } else {
            echo 'KO';
        }
    }

    /**
     * @return void
     */
    public function actionGetAllLogin(): void
    {
        echo json_encode(User::getAllLogin());
    }

    /**
     * @return void
     */
    public function actionGetAllEmail(): void
    {
        echo json_encode(User::getAllEmail());
    }
}
