<?php

namespace app\components;

use PDO;

class DB
{
    /**
     * Get connected object of PDO Class
     * @return PDO
     */
    public static function getConnection()
    {
        $settings = include ROOT . 'config/database.php';

        $db = new PDO($settings['dns'], $settings['user'], $settings['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
