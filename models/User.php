<?php

namespace app\models;

use app\components\DB;
use PDO;

class User
{
    const HASH_ALGO = PASSWORD_DEFAULT;

    public static function add(string $login, string $email, string $password, string $vkey) : void
    {
        $db = DB::getConnection();

        $sql = 'INSERT INTO user (login, password, email, vkey) '
            . 'VALUES (:login, :password, :email, :vkey)';
        $password = password_hash($password, self::HASH_ALGO);

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login);
        $result->bindParam(':password', $password);
        $result->bindParam(':email', $email);
        $result->bindParam(':vkey', $vkey);
        $result->execute();
    }

    public static function confirmMail(string $vkey) : bool
    {
        $db = DB::getConnection();

        $sql = "SELECT verified, vkey FROM user WHERE verified = 0 AND vkey = '$vkey' LIMIT 1";

        $result = $db->query($sql);
        if ($result->rowCount() != 1)
            return false;

        $sql = "UPDATE user SET verified = 1, vkey = '0' WHERE vkey = '$vkey' LIMIT 1";
        $db->query($sql);
        return true;
    }

    public static function login(string $login, string $password) : int
    {
        $dvr = require 'config/form_validation_rules.php';

        if (preg_match($dvr['login'], $login) // regular expression validate (login)
            && preg_match($dvr['password'], $password)) // regular expression validate (password)
        {
            $db = DB::getConnection();

            $sql = 'SELECT id, password, verified, email  FROM user WHERE login = :login LIMIT 1';

            $result = $db->prepare($sql);
            $result->bindParam(':login', $login);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $user = $result->fetchAll();
            if ($user && $user['verified'] == '1')
            {
                $hash = password_hash($password, self::HASH_ALGO);
                if (password_verify($password, $hash))
                    return
//                echo "<pre>" . var_dump($user) . "</pre>";
            }
        }
        return null;
    }

    public static function checkVerification(string $login) : bool
    {
        $dvr = require 'config/form_validation_rules.php';

        if (preg_match($dvr['login'], $login) // regular expression validate (login)
            && preg_match($dvr['password'], $password)) // regular expression validate (password)
            return true;
        return false;
    }

    public static function loginValidate(string $login, string $password) : bool
    {
        $dvr = require 'config/form_validation_rules.php';

        if (preg_match($dvr['login'], $login) // regular expression validate (login)
            && preg_match($dvr['password'], $password)) // regular expression validate (password)
        {
            $db = DB::getConnection();

            $sql = 'SELECT password FROM user WHERE login = :login LIMIT 1';
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $user = $result->fetchAll();

            if ($user && password_verify($user['password'], password_hash($user['password'], self::HASH_ALGO)))
                return true;
        }
        return false;
    }

    public static function registerValidate(string $login, string $email,
                                            string $password, string $password_confirm) : bool
    {
        $dvr = require 'config/form_validation_rules.php';

        if (preg_match($dvr['login'], $login) // regular expression validate (login)
            && preg_match($dvr['password'], $password) // regular expression validate (password)
            && $password == $password_confirm // password == password-confirm validate
            && filter_var($email, FILTER_VALIDATE_EMAIL)) // validate email
        {
            $db = DB::getConnection();

            if (!DB::isArgExists('user', 'login', $login, $db) // validate if no such login in DB
                && !DB::isArgExists('user', 'email', $email, $db)) // validate if no such email in DB
                return true;
        }
        return false;
    }
}
