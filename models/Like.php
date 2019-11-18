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
    public static function action(int $user_id, int $photo_id, int $like_status): void
    {
        $where = ['user_id', $user_id, 'photo_id', $photo_id];
        $user_like = self::db()->selectCol(self::TABLE, 'like_status', $where);

        if (is_string($user_like)) {
            if ($user_like == $like_status) {
                self::delete($user_like, $photo_id, $where);
            } else {
                self::update($user_like, $photo_id, $like_status, $where);
            }
        } else {
            self::insert($photo_id, $user_id, $like_status);
        }
    }

    /**
     * @param int $user_like
     * @param int $photo_id
     * @param array $where
     * @return void
     */
    private static function delete(int $user_like, int $photo_id, array $where): void
    {
        self::db()->delete(self::TABLE, $where, 1);
        if ($user_like === 1) {
            Photo::updateLikes($photo_id, 'likes', '-');
        } else {
            Photo::updateLikes($photo_id, 'dislikes', '-');
        }
    }

    /**
     * @param int $user_like
     * @param int $photo_id
     * @param int $like_status
     * @param array $where
     * @return void
     */
    private static function update(int $user_like, int $photo_id, int $like_status, array $where): void
    {
        self::db()->update(self::TABLE, ['like_status', $like_status], $where, 1);
        if ($user_like == 1) {
            Photo::updateLikes($photo_id, 'likes', '-');
            Photo::updateLikes($photo_id, 'dislikes', '+');
        } else {
            Photo::updateLikes($photo_id, 'dislikes', '-');
            Photo::updateLikes($photo_id, 'likes', '+');
        }
    }

    /**
     * @param int $photo_id
     * @param int $user_id
     * @param int $like_status
     * @return void
     */
    private static function insert(int $photo_id, int $user_id, int $like_status): void
    {
        self::db()->insert(self::TABLE, ['user_id', $user_id, 'photo_id', $photo_id, 'like_status', $like_status]);
        if ($like_status == 1) {
            Photo::updateLikes($photo_id, 'likes', '+');
        } else {
            Photo::updateLikes($photo_id, 'dislikes', '+');
        }
    }
}
