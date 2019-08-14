<?php

namespace app\models;

use app\components\lib\DB;
use app\components\lib\Modal;
use PDO;

abstract class User extends Modal
{
    public static function add(string $login, string $email, string $password, string $vkey) : void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);
//$db = DB::getConnection();
        $sql = 'INSERT INTO user (login, password, email, vkey) VALUES (:login, :password, :email, :vkey)';
        $params = array(
            ':login' => $login,
            ':password' => $password,
            ':email' => $email,
            ':vkey' => $vkey,
        );
        DB::execute($sql, $params);
//        $result = $db->prepare($sql);
//        $result->bindParam(':login', $login);
//        $result->bindParam(':password', $password);
//        $result->bindParam(':email', $email);
//        $result->bindParam(':vkey', $vkey);
//        $result->execute();
    }

    public static function changePasswordByLogin(string $login, string $password) : void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        $sql = "UPDATE user SET password = :password WHERE login = :login LIMIT 1";
        DB::execute($sql, [':password' => $password, ':login' => $login]);
    }

    public static function confirmMail(string $vkey) : bool
    {
        $db = DB::getConnection();

        $sql = "SELECT verified, vkey FROM user WHERE verified = 0 AND vkey = :vkey LIMIT 1";
        $result = DB::execute($sql, [':vkey' => $vkey], $db);
        if ($result->rowCount() != 1)
            return false;

        $sql = "UPDATE user SET verified = 1 WHERE vkey = :vkey LIMIT 1";
        DB::execute($sql, [':vkey' => $vkey], $db);
        return true;
    }

    private static function baseValidation($login, $password) : ?array
    {
        $errors = null;
        $dvr = require self::FVR_PATH;

        if (!preg_match($dvr['login'], $login))
            $errors[] = 'Invalid login';
        if (!preg_match($dvr['password'], $password))
            $errors[] = 'Invalid password';
        return $errors;
    }

    public static function loginValidate(string $login, string $password) : array
    {
        $errors = self::baseValidation($login, $password);

        if ($errors)
            return $errors;

        $sql = 'SELECT id, password, verified, email FROM user WHERE login = :login LIMIT 1';
        $result = DB::execute($sql, [':login' => $login]);

        $user = $result->fetch(PDO::FETCH_ASSOC);
        if (!$user)
            return ["<b>$login</b> is not registered"];
        if (!password_verify($password, $user['password']))
            return ['username or password is not correct'];
        if ($user['verified'] == '0')
            return ['email' => $user['email']];
        return ['id' => $user['id']];
    }

    public static function registerValidate(string $login, string $email,
                                            string $password, string $password_confirm) : ?array
    {
        $errors = self::baseValidation($login, $password);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'Invalid email';
        if ($password != $password_confirm)
            $errors[] = 'Passwords are not equal';
        if (!$errors)
        {
            $db = DB::getConnection();

            if (DB::isArgExists('user', 'login', $login, $db))
                $errors[] = "<b>$login</b> is already taken";
            if (DB::isArgExists('user', 'email', $email, $db))
                $errors[] = "<b>$email</b> is already registered";
        }
        return $errors;
    }

    public static function getLoginByEmail(string $email) : ?string
    {
        $sql = 'SELECT login FROM user WHERE email = :email LIMIT 1';

        $result = DB::execute($sql, ['$:email' => $email]);
        $login = $result->fetch(PDO::FETCH_ASSOC);
        return $login['login'];
    }

    public static function login(string $id) : void
    {
        $_SESSION['user'] = $id;
    }

    public static function logout() : void
    {
        unset($_SESSION['user']);
    }

    public static function isGuest()
    {
        if (isset($_SESSION['user']))
            return false;
        return true;
    }
}
