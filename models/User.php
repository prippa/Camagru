<?php

namespace app\models;

use app\core\Modal;
use app\components\lib\Lib;

/**
 * Class User
 * @package app\models
 */
abstract class User extends Modal
{
    /**
     * Table name
     */
    private const TABLE = 'user';

    /**
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $vkey
     * @return void
     */
    public static function insert(string $login, string $email, string $password, string $vkey): void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        self::db()->insert(self::TABLE, ['login', $login, 'password', $password, 'email', $email, 'vkey', $vkey]);
    }

    /**
     * @param int $id
     * @param string $login
     * @return void
     */
    public static function updateLogin(int $id, string $login): void
    {
        self::db()->update(self::TABLE, ['login', $login], ['id', $id], 1);
    }

    /**
     * @param string $email
     * @param int $id
     * @return void
     */
    public static function updateEmail(string $email, int $id): void
    {
        self::db()->update(self::TABLE, ['email', $email], ['id', $id], 1);
    }

    /**
     * @param string $password
     * @param int $id
     * @return void
     */
    public static function updatePassword(string $password, int $id): void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        self::db()->update(self::TABLE, ['password', $password], ['id', $id], 1);
    }

    /**
     * @param string $notification
     * @param int $id
     * @return void
     */
    public static function updateNotifications(string $notification, int $id): void
    {
        self::db()->update(self::TABLE, ['notifications', $notification], ['id', $id], 1);
    }

    /**
     * @param string $login
     * @param string $password
     * @return void
     */
    public static function updatePasswordByLogin(string $login, string $password): void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        self::db()->update(self::TABLE, ['password', $password], ['login', $login], 1);
    }

    /**
     * @param string $vkey
     * @return bool
     */
    public static function confirmMail(string $vkey): bool
    {
        $result = self::db()->select(self::TABLE, ['verified', 'vkey'], ['verified', 0, 'vkey', $vkey], 1);
        if ($result->rowCount() != 1) {
            return false;
        }

        self::db()->update(self::TABLE, ['verified', 1], ['vkey', $vkey], 1);

        return true;
    }

    /**
     * @param string $login
     * @return bool
     */
    public static function checkLogin(string $login): bool
    {
        $regex_rule = json_decode(file_get_contents(self::FIELDS_VALIDATION_PATH), true);

        if (preg_match("~{$regex_rule['username']}~", $login)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $password
     * @return bool
     */
    public static function checkPassword(string $password): bool
    {
        $regex_rule = json_decode(file_get_contents(self::FIELDS_VALIDATION_PATH), true);

        if (preg_match("~{$regex_rule['password']}~", $password)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function checkEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * @param $login
     * @param $password
     * @return array|null
     */
    private static function baseValidation($login, $password): ?array
    {
        $errors = null;

        if (!self::checkLogin($login)) {
            $errors[] = 'Invalid login';
        }
        if (!self::checkPassword($password)) {
            $errors[] = 'Invalid password';
        }

        return $errors;
    }

    /**
     * @param string $login
     * @param string $password
     * @return array
     */
    public static function loginValidate(string $login, string $password): array
    {
        $errors = self::baseValidation($login, $password);

        if ($errors) {
            return $errors;
        }

        $user = self::db()->selectRow(self::TABLE, ['id', 'password', 'verified', 'email'], ['login', $login]);
        if (!$user) {
            return ["<b>$login</b> is not registered"];
        }
        if (!password_verify($password, $user['password'])) {
            return ['username or password is not correct'];
        }
        if ($user['verified'] == '0') {
            return ['email' => $user['email']];
        }

        return ['id' => $user['id']];
    }

    /**
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $password_confirm
     * @return array|null
     */
    public static function registerValidate(string $login,
                                            string $email,
                                            string $password,
                                            string $password_confirm) : ?array
    {
        $errors = self::baseValidation($login, $password);

        if (!self::checkEmail($email)) {
            $errors[] = 'Invalid email';
        }
        if ($password != $password_confirm) {
            $errors[] = 'Passwords are not equal';
        }

        if (!$errors) {
            if (self::db()->selectCol(self::TABLE, 'login', ['login', $login])) {
                $errors[] = "<b>$login</b> is already taken";
            }
            if (self::db()->selectCol(self::TABLE, 'email', ['email', $email])) {
                $errors[] = "<b>$email</b> is already registered";
            }
        }

        return $errors;
    }

    /**
     * @param string $email
     * @return string|null
     */
    public static function getLoginByEmail(string $email): ?string
    {
        return self::db()->selectCol(self::TABLE, 'login', ['email', $email]);
    }

    /**
     * @param string $email
     * @return string|null
     */
    public static function getVerifiedByEmail(string $email): ?string
    {
        return self::db()->selectCol(self::TABLE, 'verified', ['email', $email]);
    }

    /**
     * @param int $id
     * @return string|null
     */
    public static function getLogin(int $id): ?string
    {
        return self::db()->selectCol(self::TABLE, 'login', ['id', $id]);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function getUser(int $id): ?array
    {
        return self::db()->selectRow(self::TABLE, [], ['id', $id]);
    }

    /**
     * @return array
     */
    public static function getAllLogin(): array
    {
        return self::db()->selectRows(self::TABLE, ['login']);
    }

    /**
     * @return array
     */
    public static function getAllEmail(): array
    {
        return self::db()->selectRows(self::TABLE, ['email']);
    }

    /**
     * @param string $id
     * @return void
     */
    public static function login(string $id): void
    {
        $_SESSION['user'] = $id;
    }

    /**
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * @return bool
     */
    public static function isLogged(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }

    /**
     * @return int|null
     */
    public static function getId(): ?int
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return null;
    }

    /**
     * @return void
     */
    public static function redirectToLoginCheck(): void
    {
        if (!self::isLogged()) {
            Lib::redirect('login');
        }
    }

    /**
     * @return void
     */
    public static function redirectToHomeCheck(): void
    {
        if (self::isLogged()) {
            Lib::redirect();
        }
    }
}
