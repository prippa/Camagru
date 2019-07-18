<?php

namespace app\models;

use app\components\DB;

class User
{
    public static function add(string $login, string $email, string $password, string $vkey) : void
    {
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

    /**
     * Return false if new user is not valid
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $password_confirm
     * @return bool
     */
    public static function validate(string $login, string $email, string $password, string $password_confirm) : bool
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
