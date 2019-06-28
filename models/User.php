<?php

namespace app\models;

use app\components\lib\Lib;

class User
{
    /**
     * Return false if data is not valid
     * @param array $data
     * @return bool
     */
    public static function insertNewUser(array $data) : bool
    {
        $dvr = Lib::getConfigArray(CONFIG . 'form_validation_rules.php');

        if (preg_match($dvr['username'], $data['username'])
            && preg_match($dvr['password'], $data['password'])
            && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) // data validation
        {
            return true;
        }
        return false;
    }
}
