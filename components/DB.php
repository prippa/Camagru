<?php

namespace app\components;

use PDO;
use app\components\lib\Lib;

class DB
{
    /**
     * Get connected object of PDO Class
     */
    public static function getConnection() : PDO
    {
        $settings = Lib::getConfigArray(CONFIG . 'database.php');

        $dns = 'mysql:dbname=' . $settings['dbname'] . ';host=' . $settings['host'];
        $db = new PDO($dns, $settings['user'], $settings['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
