<?php

namespace app\models;

use app\components\lib\DB;
use PDO;

abstract class Comment
{
    public static function add(int $user_id, int $photo_id, string $comment): void
    {
        $sql = 'INSERT INTO photo_comment (user_id, photo_id, comment) VALUES (:user_id, :photo_id, :comment)';
        DB::execute($sql, [':user_id' => $user_id, ':photo_id' => $photo_id, ':comment' => $comment]);
    }

    public static function getByID(int $id): ?array
    {
        $sql = 'SELECT user_id, photo_id, comment FROM photo_comment WHERE id = :id';

        $result = DB::execute($sql, [':id' => $id]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllCommentsByPhotoId(int $photo_id): ?array
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
}
