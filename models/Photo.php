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
}
