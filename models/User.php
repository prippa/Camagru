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
        $db = Lib::
        if (preg_match('~^[\w]$~', $data['username'])) // data validation
            return true;
        // insert to DB
        return false;
    }
}
