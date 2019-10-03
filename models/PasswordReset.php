<?php

namespace app\models;

use app\components\lib\DB;
use PDO;

abstract class PasswordReset extends Modal
{
    public static function validation(string $email) : ?array
    {
        $db = DB::getConnection();

        $sql = 'SELECT verified FROM user WHERE email = :email LIMIT 1';
        $result = DB::execute($sql, [':email' => $email], $db);

        $user = $result->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return ["Can't find that email, sorry."];
        }
        if ($user['verified'] == '0') {
            return ['account_email'];
        }

        $sql = 'SELECT email FROM password_reset WHERE email = :email LIMIT 1';
        $result = DB::execute($sql, [':email' => $email], $db);

        if ($result->fetch()) {
            return ['password_email'];
        }

        return null;
    }

    public static function formValidation(string $password, string $password_confirm) : ?array
    {
        $errors = null;
        $dvr = require self::FVR_PATH;

        if (!preg_match($dvr['password'], $password)) {
            $errors[] = 'Invalid password';
        }
        if ($password != $password_confirm) {
            $errors[] = 'Passwords are not equal';
        }

        return $errors;
    }

    public static function add(string $email, string $token) : void
    {
        $sql = 'INSERT INTO password_reset (email, token) VALUES (:email, :token)';
        DB::execute($sql, [':email' => $email, ':token' => $token]);
    }

    public static function getEmailByToken(string $token) : ?string
    {
        $sql = 'SELECT email FROM password_reset WHERE token = :token LIMIT 1';
        $result = DB::execute($sql, [':token' => $token]);

        $email = $result->fetch(PDO::FETCH_ASSOC);

        return $email['email'];
    }

    public static function deleteByEmail(string $email) : void
    {
        $sql = 'DELETE FROM password_reset WHERE email = :email LIMIT 1';
        DB::execute($sql, [':email' => $email]);
    }
}
