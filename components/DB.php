<?php

namespace app\components;

use PDO;

class DB
{
    /**
     * Get connected object of PDO Class
     */
    public static function getConnection() : PDO
    {
        $settings = require 'config/database.php';
        $dns = "mysql:dbname={$settings['dbname']};host={$settings['host']}";

        $db = new PDO($dns, $settings['user'], $settings['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }

    public static function select($statement, PDO $db=null, $fetch_mod=PDO::FETCH_ASSOC) : array
    {
        if (!$db)
            $db = self::getConnection();

        $result = $db->query('SELECT ' . $statement);
        $result->setFetchMode($fetch_mod);

        return $result->fetchAll();
    }
}
