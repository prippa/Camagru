<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\View;
use app\models\Comment;
use app\models\Like;
use app\models\Photo;
use app\models\User;
use DateTime;

class SiteController
{
    public function actionIndex()
    {
        $posts = Photo::getLastNPhotos(6, User::getId());

        foreach ($posts as &$post)
        {
            $post['create_date'] = (new DateTime($post['create_date']))->format('d M Y H:i');
            $post['comments'] = Comment::getAllCommentsByPhotoId($post['id']);
        }

        View::run(View::INDEX, ['posts' => $posts]);
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

        $photo_user_id = Photo::getUserIdById($photo_id);

        if ($user_id != $photo_user_id)



        exit('OK');
    }
}
