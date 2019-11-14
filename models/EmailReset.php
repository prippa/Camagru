<?php

namespace app\models;

use app\core\Modal;

abstract class EmailReset extends Modal
{
    private const TABLE = 'email_reset';

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

    public static function checkEmail(string $email): bool
    {
        if (self::db()->selectCol(self::TABLE, 'email', ['email', $email])) {
            return true;
        }

        return false;
    }
}
