<?php

namespace app\models;

use app\components\lib\DB;
use PDO;

abstract class Photo
{
    public static function add(string $img, int $user_id) : void
    {
        $sql = 'INSERT INTO photo (user_id, img) VALUES (:user_id, :img)';
        DB::execute($sql, [':user_id' => $user_id, ':img' => $img]);
    }

    public static function getPhotoComments(int $photo_id) : ?array
    {
        $sql = 'SELECT
                    photo_comment.comment,
                    user.login
                FROM photo_comment
                LEFT JOIN user ON photo_comment.user_id = user.id
                WHERE photo_comment.photo_id = :photo_id
                ORDER BY photo_comment.create_date';

        $result = DB::execute($sql, [':photo_id' => $photo_id]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastNPhotos(int $size, ?int $user_id) : ?array
    {
        $sql = 'SELECT
                    likes.like_status,
                    user.login,
                    photo.create_date,
                    photo.img,
                    photo.likes,
                    photo.dislikes,
                    photo.id
                FROM photo
                LEFT JOIN user ON photo.user_id = user.id
                LEFT JOIN likes ON :user_id = likes.user_id AND photo.id = likes.photo_id
                ORDER BY photo.create_date DESC limit ' . $size;

        $result = DB::execute($sql, [':user_id' => $user_id]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function like(int $user_id, int $photo_id, int $like_status) : void
    {
        $db = DB::getConnection();
        $sql_postfix = 'user_id = :user_id AND photo_id = :photo_id LIMIT 1';
        $sql = 'SELECT like_status FROM likes WHERE ' . $sql_postfix;

        $result = DB::execute($sql, [':user_id' => $user_id, ':photo_id' => $photo_id], $db);
        $user_like_row = $result->fetch(PDO::FETCH_ASSOC);

        if ($user_like_row)
        {
            if ($user_like_row['like_status'] == $like_status)
            {
                $sql = 'DELETE FROM likes WHERE ' . $sql_postfix;
                DB::execute($sql, [':user_id' => $user_id, ':photo_id' => $photo_id], $db);
            }
            else
            {
                $sql = 'UPDATE likes SET like_status = :like_status WHERE ' . $sql_postfix;
                DB::execute($sql,
                    [':like_status' => $like_status, ':user_id' => $user_id, ':photo_id' => $photo_id], $db);
            }
        }
        else
        {
            $sql = 'INSERT INTO likes (user_id, photo_id, like_status) VALUES (:user_id, :photo_id, :like_status)';
            DB::execute($sql,
                [':user_id' => $user_id, ':photo_id' => $photo_id, ':like_status' => $like_status], $db);
        }
    }

    public static function comment(int $user_id, int $photo_id, string $comment) : void
    {
        $sql = 'INSERT INTO photo_comment (user_id, photo_id, comment) VALUES (:user_id, :photo_id, :comment)';
        DB::execute($sql, [':user_id' => $user_id, ':photo_id' => $photo_id, ':comment' => $comment]);
    }
}
