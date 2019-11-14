<?php

namespace app\models;

use app\core\Modal;

abstract class Comment extends Modal
{
    private const TABLE = 'photo_comment';

    public static function insert(int $user_id, int $photo_id, string $comment): void
    {
        self::db()->insert(self::TABLE, ['user_id', $user_id, 'photo_id', $photo_id, 'comment', $comment]);
    }

    public static function getAllCommentsByPhotoId(int $photo_id): ?array
    {
        $sql = 'SELECT
                    photo_comment.comment,
                    user.login
                FROM ' . self::TABLE . '
                LEFT JOIN user ON photo_comment.user_id = user.id
                WHERE photo_comment.photo_id = :photo_id
                ORDER BY photo_comment.create_date';

        return self::db()->rows($sql, ['photo_id', $photo_id]);
    }
}
