<?php

namespace app\components;

use PDO;

class DB
{
    public static function getConnection()
    {
        $params = require ROOT . '/config/database.php';

        $dns = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dns, $params['user'], $params['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
