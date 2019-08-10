<?php

namespace app\models;

use app\components\DB;
use PDO;

class User
{
    private const FVR_PATH = 'config/form_validation_rules.php';
    private const PASSWORD_HASH_TYPE = PASSWORD_DEFAULT;

    public static function add(string $login, string $email, string $password, string $vkey) : void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);
        $db = DB::getConnection();

        $sql = 'INSERT INTO user (login, password, email, vkey) '
            . 'VALUES (:login, :password, :email, :vkey)';
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login);
        $result->bindParam(':password', $password);
        $result->bindParam(':email', $email);
        $result->bindParam(':vkey', $vkey);
        $result->execute();
    }

    public static function changePasswordByLogin(string $login, string $password) : void
    {
        $password = password_hash($password, self::PASSWORD_HASH_TYPE);

        $db = DB::getConnection();

        $sql = "UPDATE user SET password = :pass WHERE login = :login LIMIT 1";
        $result = $db->prepare($sql);
        $result->bindParam(':pass', $password);
        $result->bindParam(':login', $login);
        $result->execute();
    }

    public static function confirmMail(string $vkey) : bool
    {
        $db = DB::getConnection();

        $sql = "SELECT verified, vkey FROM user WHERE verified = 0 AND vkey = :vkey LIMIT 1";
        $result = $db->prepare($sql);
        $result->bindParam(':vkey', $vkey);
        $result->execute();
        if ($result->rowCount() != 1)
            return false;

        $sql = "UPDATE user SET verified = 1 WHERE vkey = :vkey LIMIT 1";
        $result = $db->prepare($sql);
        $result->bindParam(':vkey', $vkey);
        $result->execute();
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

        $db = DB::getConnection();

        $sql = 'SELECT id, password, verified, email FROM user WHERE login = :login LIMIT 1';
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $user = $result->fetch();
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

    public static function passwordResetValidation(string $email) : ?array
    {
        $db = DB::getConnection();

        $sql = 'SELECT verified FROM user WHERE email = :email LIMIT 1';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $user = $result->fetch();
        if (!$user)
            return ["Can't find that email, sorry."];
        if ($user['verified'] == '0')
            return ['account_email'];

        $sql = 'SELECT email FROM password_reset WHERE email = :email LIMIT 1';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();

        if ($result->fetch())
            return ['password_email'];
        return null;
    }

    public static function passwordResetFormValidation(string $password, string $password_confirm) : ?array
    {
        $errors = null;
        $dvr = require self::FVR_PATH;

        if (!preg_match($dvr['password'], $password))
            $errors[] = 'Invalid password';
        if ($password != $password_confirm)
            $errors[] = 'Passwords are not equal';
        return $errors;
    }

    public static function passwordResetAdd(string $email, string $token) : void
    {
        $db = DB::getConnection();

        $sql = 'INSERT INTO password_reset (email, token) '
            . 'VALUES (:email, :token)';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email);
        $result->bindParam(':token', $token);
        $result->execute();
    }

    public static function passwordResetGetEmailByVkey(string $token) : ?string
    {
        $db = DB::getConnection();

        $sql = 'SELECT email FROM password_reset WHERE token = :token LIMIT 1';
        $result = $db->prepare($sql);
        $result->bindParam(':token', $token);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $email = $result->fetch();
        return $email['email'];
    }

    public static function passwordResetDeleteByEmail(string $email) : void
    {
        $db = DB::getConnection();

        $sql = 'DELETE FROM password_reset WHERE email = :email LIMIT 1';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();
    }

    public static function getLoginByEmail(string $email) : ?string
    {
        $db = DB::getConnection();

        $sql = 'SELECT login FROM user WHERE email = :email LIMIT 1';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $login = $result->fetch();
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
