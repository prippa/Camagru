<?php

namespace app\components\lib;

use PDO;
use PDOStatement;

abstract class DB
{
    /**
     * Get connected object of PDO Class
     */
    public static function getConnection() : PDO
    {
        $settings = require 'config/database.php';
        $dns = "mysql:dbname={$settings['dbname']};host={$settings['host']}";

        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        $db = new PDO($dns, $settings['user'], $settings['password'], $options);

        return $db;
    }

    public static function isArgExists(string $table, string $column, string $arg, PDO $db=null) : array
    {
        if (!$db)
            $db = self::getConnection();

        $sql = "SELECT $column FROM $table WHERE $column = :arg LIMIT 1";
        $result = self::execute($sql, [':arg' => $arg], $db);

        return $result->fetchAll();
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @param PDO|null $db
     * @return bool|PDOStatement
     */
    public static function execute(string $sql, array $params=[], PDO $db=null)
    {
        if (!$db)
            $db = self::getConnection();

        $result = $db->prepare($sql);
        foreach ($params as $key => &$value)
            $result->bindParam($key, $value);
        $result->execute();
        return $result;
    }
}
