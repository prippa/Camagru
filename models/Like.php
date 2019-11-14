<?php

namespace app\models;

use app\core\Modal;

abstract class Like extends Modal
{
    private const TABLE = 'likes';

    public static function action(int $user_id, int $photo_id, int $like_status): void
    {
        $where = ['user_id', $user_id, 'photo_id', $photo_id];
        $user_like = self::db()->selectCol(self::TABLE, 'like_status', $where);

        if ($user_like) {
            if ($user_like == $like_status) {
                self::db()->delete(self::TABLE, $where, 1);
            } else {
                self::db()->update(self::TABLE, ['like_status', $like_status], $where, 1);
            }
        } else {
            self::db()->insert(self::TABLE, ['user_id', $user_id, 'photo_id', $photo_id, 'like_status', $like_status]);
        }
    }
}
