<?php

namespace app\models;

use app\components\lib\DB;
use PDO;

abstract class Photo
{
    public static function add(string $filename, int $user_id) : void
    {
        $sql = 'INSERT INTO photo (user_id, filename) VALUES (:user_id, :filename)';
        DB::execute($sql, [':user_id' => $user_id, ':filename' => $filename]);
    }

    public static function getLastNPhotos(int $size) : array
    {
        $sql = 'SELECT
                    likes.like_status,
                    user.login,
                    photo.filename,
                    photo.likes,
                    photo.dislikes,
                    photo.id
                FROM photo
                LEFT JOIN user ON photo.user_id = user.id
                LEFT JOIN likes ON photo.user_id = likes.user_id AND photo.id = likes.photo_id
                ORDER BY
                    photo.create_date DESC limit ' . $size;

        $result = DB::execute($sql);

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
}
