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
        if (false) // data validation
            return false;
        // insert to DB
        return true;
    }
}
