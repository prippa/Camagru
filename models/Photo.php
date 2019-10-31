<?php

namespace app\models;

use app\components\lib\DB;
use DateTime;
use PDO;

abstract class Photo
{
    public static function add(string $img, int $user_id): void
    {
        $sql = 'INSERT INTO photo (user_id, img) VALUES (:user_id, :img)';
        DB::execute($sql, [':user_id' => $user_id, ':img' => $img]);
    }

    public static function deleteById(int $id): void
    {
        $sql = 'DELETE FROM photo WHERE id = :id LIMIT 1';
        DB::execute($sql, [':id' => $id]);
    }

    public static function getLastNPhotos(int $size, ?int $user_id, int $start_from = 0): ?array
    {
        $sql = "SELECT
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
                ORDER BY photo.create_date DESC LIMIT $size OFFSET $start_from";

        $result = DB::execute($sql, [':user_id' => $user_id]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastNUserPhotos(int $size, int $user_id, int $start_from = 0): ?array
    {
        $sql = "SELECT
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
                WHERE :user_id = photo.user_id
                ORDER BY photo.create_date DESC LIMIT $size OFFSET $start_from";

        $result = DB::execute($sql, [':user_id' => $user_id]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function preparePhotos(?array &$photos): void
    {
        foreach ($photos as &$photo) {
            $photo['create_date'] = (new DateTime($photo['create_date']))->format('d M Y H:i');
            $photo['link'] = "/photo/{$photo['id']}";
        }
    }

    public static function getPhotoById(int $id, ?int $user_id): ?array
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
                WHERE photo.id = :id LIMIT 1';

        $result = DB::execute($sql, [':user_id' => $user_id, ':id' => $id]);

        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data ? $data : null;
    }

    public static function getUserIdById(int $id): ?int
    {
        $sql = 'SELECT user_id FROM photo WHERE id = :id LIMIT 1';

        $result = DB::execute($sql, [':id' => $id]);

        return $result->fetch(PDO::FETCH_ASSOC)['user_id'];
    }

    public static function getFileById(int $id): ?string
    {
        $sql = 'SELECT img FROM photo WHERE id = :id LIMIT 1';

        $result = DB::execute($sql, [':id' => $id]);

        return $result->fetch(PDO::FETCH_ASSOC)['img'];
    }
}
