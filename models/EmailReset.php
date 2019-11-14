<?php

namespace app\models;

use app\core\Modal;

/**
 * Class EmailReset
 * @package app\models
 */
abstract class EmailReset extends Modal
{
    /**
     * Table name
     */
    private const TABLE = 'email_reset';

    /**
     * @param string $email
     * @param string $token
     * @return void
     */
    public static function insert(string $email, string $token): void
    {
        self::db()->insert(self::TABLE, ['email', $email, 'token', $token]);
    }

    /**
     * @param string $token
     * @return string|null
     */
    public static function getEmailByToken(string $token): ?string
    {
        return self::db()->selectCol(self::TABLE, 'email', ['token', $token]);
    }

    /**
     * @param string $email
     * @return void
     */
    public static function deleteByEmail(string $email): void
    {
        self::db()->delete(self::TABLE, ['email', $email], 1);
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function checkEmail(string $email): bool
    {
        if (self::db()->selectCol(self::TABLE, 'email', ['email', $email])) {
            return true;
        }

        return false;
    }
}
