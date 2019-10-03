<?php

namespace app\models;

use app\components\lib\DB;
use PDO;

abstract class EmailReset
{
    public static function add(string $email, string $token) : void
    {
        $sql = 'INSERT INTO email_reset (email, token) VALUES (:email, :token)';
        DB::execute($sql, [':email' => $email, ':token' => $token]);
    }

    public static function getEmailByToken(string $token) : ?string
    {
        $sql = 'SELECT email FROM email_reset WHERE token = :token LIMIT 1';
        $result = DB::execute($sql, [':token' => $token]);

        $email = $result->fetch(PDO::FETCH_ASSOC);
        return $email['email'];
    }

    public static function deleteByEmail(string $email) : void
    {
        $sql = 'DELETE FROM email_reset WHERE email = :email LIMIT 1';
        DB::execute($sql, [':email' => $email]);
    }

    public static function checkEmail(string $email) : bool
    {
        if (DB::isArgExists('email_reset', 'email', $email)) {
            return true;
        }

        return false;
    }
}
