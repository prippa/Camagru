<?php

namespace app\models;

use app\core\Modal;

/**
 * Class Like
 * @package app\models
 */
abstract class Like extends Modal
{
    /**
     * Table name
     */
    private const TABLE = 'likes';

    /**
     * @param int $user_id
     * @param int $photo_id
     * @param int $like_status
     * @return void
     */
    public static function make(int $user_id, int $photo_id, int $like_status): void
    {
        $where = ['user_id', $user_id, 'photo_id', $photo_id];
        $user_like = self::db()->selectCol(self::TABLE, 'like_status', $where);

        if (is_string($user_like)) {
            if ($user_like == $like_status) {
                self::db()->delete(self::TABLE, $where, 1);
                if ($user_like == 1) {
                    Photo::updateLikes($photo_id, 'likes', '-');
                } else {
                    Photo::updateLikes($photo_id, 'dislikes', '-');
                }
            } else {
                self::db()->update(self::TABLE, ['like_status', $like_status], $where, 1);
                if ($user_like == 1) {
                    Photo::updateLikes($photo_id, 'likes', '-');
                    Photo::updateLikes($photo_id, 'dislikes', '+');
                } else {
                    Photo::updateLikes($photo_id, 'dislikes', '-');
                    Photo::updateLikes($photo_id, 'likes', '+');
                }
            }
        } else {
            self::db()->insert(self::TABLE, ['user_id', $user_id, 'photo_id', $photo_id, 'like_status', $like_status]);
            if ($like_status == 1) {
                Photo::updateLikes($photo_id, 'likes', '+');
            } else {
                Photo::updateLikes($photo_id, 'dislikes', '+');
            }
        }
    }
}
