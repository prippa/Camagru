<?php

namespace app\models;

use app\core\Modal;

/**
 * Class Comment
 * @package app\models
 */
abstract class Comment extends Modal
{
    /**
     * Table name
     */
    private const TABLE = 'photo_comment';

    /**
     * @param int $user_id
     * @param int $photo_id
     * @param string $comment
     * @return void
     */
    public static function insert(int $user_id, int $photo_id, string $comment): void
    {
        self::db()->insert(self::TABLE, ['user_id', $user_id, 'photo_id', $photo_id, 'comment', $comment]);
    }

    /**
     * @param int $photo_id
     * @return array|null
     */
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
