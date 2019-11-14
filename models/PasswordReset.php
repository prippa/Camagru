<?php

namespace app\models;

use app\core\Modal;

abstract class PasswordReset extends Modal
{
    private const TABLE = 'password_reset';

    public static function validation(string $email): ?array
    {
        $verified = User::getVerifiedByEmail($email);

        if (!$verified) {
            return ["Can't find that email, sorry."];
        }
        if ($verified == '0') {
            return ['account_email'];
        }
        if (self::db()->selectCol(self::TABLE, 'email', ['email', $email])) {
            return ['password_email'];
        }

        return null;
    }

    public static function formValidation(string $password, string $password_confirm): ?array
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

    public static function insert(string $email, string $token): void
    {
        self::db()->insert(self::TABLE, ['email', $email, 'token', $token]);
    }

    public static function getEmailByToken(string $token): ?string
    {
        return self::db()->selectCol(self::TABLE, 'email', ['token', $token]);
    }

    public static function deleteByEmail(string $email): void
    {
        self::db()->delete(self::TABLE, ['email', $email], 1);
    }
}
