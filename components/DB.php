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
        $settings = require CONFIG . 'database.php';

        $dns = 'mysql:dbname=' . $settings['dbname'] . ';host=' . $settings['host'];
        $db = new PDO($dns, $settings['user'], $settings['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
