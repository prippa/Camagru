<?php

namespace app\models;

use app\core\Modal;
use PDO;

abstract class Like extends Modal
{
    public static function action(int $user_id, int $photo_id, int $like_status): void
    {
        $db = DB::getConnection();
        $sql_postfix = 'user_id = :user_id AND photo_id = :photo_id LIMIT 1';
        $sql = 'SELECT like_status FROM likes WHERE ' . $sql_postfix;

        $result = DB::execute($sql, [':user_id' => $user_id, ':photo_id' => $photo_id], $db);
        $user_like_row = $result->fetch(PDO::FETCH_ASSOC);

        if ($user_like_row) {
            if ($user_like_row['like_status'] == $like_status) {
                $sql = 'DELETE FROM likes WHERE ' . $sql_postfix;
                DB::execute($sql, [':user_id' => $user_id, ':photo_id' => $photo_id], $db);
            } else {
                $sql = 'UPDATE likes SET like_status = :like_status WHERE ' . $sql_postfix;
                DB::execute(
                    $sql,
                    [':like_status' => $like_status, ':user_id' => $user_id, ':photo_id' => $photo_id],
                    $db
                );
            }
        } else {
            $sql = 'INSERT INTO likes (user_id, photo_id, like_status) VALUES (:user_id, :photo_id, :like_status)';
            DB::execute(
                $sql,
                [':user_id' => $user_id, ':photo_id' => $photo_id, ':like_status' => $like_status],
                $db
            );
        }
    }
}
