<?php

namespace app\models;

use app\components\DB;

class User
{
    public static function add(array $data) : void
    {
        $db = DB::getConnection();

        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $vkey = md5(time() . $data['username']);

        $sql = "INSERT INTO user (name, password, email, vkey) "
            . "VALUES ('{$data['username']}', '$password', '{$data['email']}', '$vkey')";
        $db->query($sql);
    }

    /**
     * Return false if new user is not valid
     * @param array $data
     * @return bool
     */
    public static function validate(array $data) : bool
    {
        $dvr = require 'config/form_validation_rules.php';

        if (preg_match($dvr['username'], $data['username']) // regular expression validate (username)
            && preg_match($dvr['password'], $data['password']) // regular expression validate (password)
            && $data['password'] == $data['password-confirm'] // password == password-confirm validate
            && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) // validate email
        {
            $db = DB::getConnection();
            $name_sql = "name FROM user WHERE name='{$data['username']}'";
            $email_sql = "email FROM user WHERE email='{$data['email']}'";

            if (!DB::select($name_sql, $db) // validate if no such username in DB
                && !DB::select($email_sql, $db)) // validate if no such email in DB
                return true;
        }
        return false;
    }
}
