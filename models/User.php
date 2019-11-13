<?php

namespace app\models;

use app\core\Modal;
use app\components\lib\Lib;
use PDO;

abstract class User extends Modal
{
    private const TABLE = 'user';

    public static function insert(string $login, string $email, string $password, string $vkey): void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        self::db()->insert(self::TABLE, ['login' => $login, 'password' => $password, 'email' => $email, 'vkey' => $vkey]);
    }

    public static function updateLogin(int $id, string $login): void
    {
        self::db()->update(self::TABLE, $id, ['login' => $login]);
    }

    public static function updateEmail(string $email, int $id): void
    {
        self::db()->update(self::TABLE, $id, ['email' => $email]);
    }

    public static function updatePassword(string $password, int $id): void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        self::db()->update(self::TABLE, $id, ['password' => $password]);
    }

    public static function updateNotifications(string $notification, int $id): void
    {
        self::db()->update(self::TABLE, $id, ['notification' => $notification]);
    }

    public static function updatePasswordByLogin(string $login, string $password): void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        $sql = "UPDATE user SET password = :password WHERE login = :login LIMIT 1";
        self::db()->execute($sql, ['password' => $password, 'login' => $login]);
    }

    public static function confirmMail(string $vkey): bool
    {
        $db = self::db()->getConnection();

        $sql = "SELECT verified, vkey FROM user WHERE verified = 0 AND vkey = :vkey LIMIT 1";
        $result = self::db()->execute($sql, [':vkey' => $vkey], $db);
        if ($result->rowCount() != 1) {
            return false;
        }

        $sql = "UPDATE user SET verified = 1 WHERE vkey = :vkey LIMIT 1";
        self::db()->execute($sql, ['vkey' => $vkey], $db);

        return true;
    }

    public static function checkLogin(string $login): bool
    {
        $regex_rule = require self::FVR_PATH;

        if (preg_match($regex_rule['login'], $login)) {
            return true;
        }

        return false;
    }

    public static function checkPassword(string $password): bool
    {
        $regex_rule = require self::FVR_PATH;

        if (preg_match($regex_rule['password'], $password)) {
            return true;
        }

        return false;
    }

    public static function checkEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

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

    public static function loginValidate(string $login, string $password): array
    {
        $errors = self::baseValidation($login, $password);

        if ($errors) {
            return $errors;
        }

        $sql = 'SELECT id, password, verified, email FROM user WHERE login = :login LIMIT 1';
        $result = self::db()->execute($sql, ['login' => $login]);

        $user = $result->fetch(PDO::FETCH_ASSOC);
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
            if (self::db()->isArgExists('user', 'login', $login, $db)) {
                $errors[] = "<b>$login</b> is already taken";
            }
            if (self::db()->isArgExists('user', 'email', $email, $db)) {
                $errors[] = "<b>$email</b> is already registered";
            }
        }

        return $errors;
    }

    public static function getLoginByEmail(string $email): ?string
    {
        $sql = 'SELECT login FROM user WHERE email = :email LIMIT 1';

        $result = self::db()->execute($sql, ['email' => $email]);
        $login = $result->fetch(PDO::FETCH_ASSOC);

        return $login['login'];
    }

    public static function getLoginById(int $id): ?string
    {
        $sql = 'SELECT login FROM user WHERE id = :id LIMIT 1';

        $result = self::db()->execute($sql, ['id' => $id]);

        return $result->fetch(PDO::FETCH_ASSOC)['login'];
    }

    public static function getUserByID(int $id): ?array
    {
        $sql = 'SELECT * FROM user WHERE id = :id LIMIT 1';

        $result = self::db()->execute($sql, ['id' => $id]);

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function login(string $id): void
    {
        $_SESSION['user'] = $id;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
    }

    public static function isLogged(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }

    public static function getId(): ?int
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return null;
    }

    public static function redirectToLoginCheck(): void
    {
        if (!self::isLogged()) {
            Lib::redirect('login');
        }
    }

    public static function redirectToHomeCheck(): void
    {
        if (self::isLogged()) {
            Lib::redirect();
        }
    }
}
