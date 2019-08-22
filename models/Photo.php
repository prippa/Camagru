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

    public static function getLast6() : array
    {
        $sql = 'SELECT user.login, photo.filename, photo.likes, photo.dislikes
                FROM photo
                INNER JOIN user ON photo.user_id = user.id
                ORDER BY photo.create_date
                DESC limit 6';

        $result = DB::execute($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
