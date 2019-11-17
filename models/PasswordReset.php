<?php

namespace app\models;

use app\core\Modal;

/**
 * Class PasswordReset
 * @package app\models
 */
abstract class PasswordReset extends Modal
{
    /**
     * Table name
     */
    private const TABLE = 'password_reset';

    /**
     * @param string $email
     * @return array|null
     */
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

    /**
     * @param string $password
     * @param string $password_confirm
     * @return array|null
     */
    public static function formValidation(string $password, string $password_confirm): ?array
    {
        $errors = null;
        $regex_rule = json_decode(file_get_contents(self::FIELDS_VALIDATION_PATH), true);

        if (!preg_match("~{$regex_rule['password']}~", $password)) {
            $errors[] = 'Invalid password';
        }
        if ($password != $password_confirm) {
            $errors[] = 'Passwords are not equal';
        }

        return $errors;
    }

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
}
