<?php

namespace app\models;

class User
{
    /**
     * Return false if data is not valid
     * @param array $data
     * @return bool
     */
    public static function insertNewUser(array $data) : bool
    {
        $dvr = require 'config/form_validation_rules.php';

        if (preg_match($dvr['username'], $data['username'])
            && preg_match($dvr['password'], $data['password'])
            && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) // data validation
        {
            return true;
        }
        return false;
    }
}
