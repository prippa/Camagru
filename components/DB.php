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

    public static function isArgExists(string $table, string $column, string $arg, PDO $db=null) : array
    {
        if (!$db)
            $db = self::getConnection();

        $sql = 'SELECT :column FROM :table WHERE :column=:arg';
        $result = $db->prepare($sql);
        $result->bindParam(':column', $column);
        $result->bindParam(':table', $table);
        $result->bindParam(':column', $column);
        $result->bindParam(':arg', $arg);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }
}
