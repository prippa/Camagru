<?php

namespace app\models;

use app\core\Modal;
use DateTime;

abstract class Photo extends Modal
{
    private const TABLE = 'photo';

    public static function insert(string $img, int $user_id): void
    {
        self::db()->insert(self::TABLE, ['user_id', $user_id, 'img', $img]);
    }

    public static function delete(int $id): void
    {
        self::db()->delete(self::TABLE, ['id', $id], 1);
    }

    public static function getLastNPhotos(int $size, ?int $user_id, int $start_from = 0): ?array
    {
        $sql = 'SELECT
                    likes.like_status,
                    user.login,
                    photo.create_date,
                    photo.img,
                    photo.likes,
                    photo.dislikes,
                    photo.id
                FROM ' . self::TABLE . '
                LEFT JOIN user ON photo.user_id = user.id
                LEFT JOIN likes ON :user_id = likes.user_id AND photo.id = likes.photo_id
                ORDER BY photo.create_date DESC LIMIT ' . $size . ' OFFSET ' . $start_from;

        return self::db()->rows($sql, ['user_id', $user_id]);
    }

    public static function getLastNUserPhotos(int $size, int $user_id, int $start_from = 0): ?array
    {
        $sql = 'SELECT
                    likes.like_status,
                    user.login,
                    photo.create_date,
                    photo.img,
                    photo.likes,
                    photo.dislikes,
                    photo.id
                FROM ' . self::TABLE . '
                LEFT JOIN user ON photo.user_id = user.id
                LEFT JOIN likes ON :user_id = likes.user_id AND photo.id = likes.photo_id
                WHERE :user_id = photo.user_id
                ORDER BY photo.create_date DESC LIMIT ' . $size . ' OFFSET ' . $start_from;

        return self::db()->rows($sql, ['user_id', $user_id]);
    }

    public static function preparePhotos(?array &$photos): void
    {
        foreach ($photos as &$photo) {
            $photo['create_date'] = (new DateTime($photo['create_date']))->format('d M Y H:i');
            $photo['link'] = "/photo/{$photo['id']}";
        }
    }

    public static function getPhoto(int $id, ?int $user_id): ?array
    {
        $sql = 'SELECT
                    likes.like_status,
                    user.login,
                    photo.create_date,
                    photo.img,
                    photo.likes,
                    photo.dislikes,
                    photo.id
                FROM ' . self::TABLE . '
                LEFT JOIN user ON photo.user_id = user.id
                LEFT JOIN likes ON :user_id = likes.user_id AND photo.id = likes.photo_id
                WHERE photo.id = :id LIMIT 1';

        $data = self::db()->row($sql, ['user_id', $user_id, 'id', $id]);

        return $data ? $data : null;
    }

    public static function getUserId(int $id): ?int
    {
        return self::db()->selectCol(self::TABLE, 'user_id', ['id', $id]);
    }

    public static function getFile(int $id): ?string
    {
        return self::db()->selectCol(self::TABLE, 'img', ['id', $id]);
    }
}
