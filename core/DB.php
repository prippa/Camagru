<?php

namespace app\core;

use PDO;

class DB
{
    protected $db;

    /**
     * Get connection to DB
     */
    public function __construct()
    {
        $settings = require 'config/database.php';
        $dns = "mysql:dbname={$settings['dbname']};host={$settings['host']}";

        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        $this->db = new PDO($dns, $settings['user'], $settings['password'], $options);
    }

    public function insert(string $table, array $params = []): void
    {
        $fields = '';
        $values = '';

        foreach ($params as $field) {
            $fields .= "$field,";
            $values .= ":$field,";
        }
        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $this->execute($sql, $params);
    }

    public function delete(string $table, int $id): void
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->execute($sql);
    }

    public function update(string $table, int $id, array $params = [])
    {
        $setString = '';

        foreach ($params as $field) {
            $setString .= "$field = :$field,";
        }
        $setString = rtrim($setString, ',');
        $sql = "UPDATE $table SET $setString WHERE id = $id";
        $this->execute($sql);
    }

    public function row(string $sql, array $params = [])
    {
        $result = $this->execute($sql, $params);
		return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function rows(string $sql, array $params = [])
    {
        $result = $this->execute($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column(string $sql, array $params = [])
    {
		$result = $this->execute($sql, $params);
		return $result->fetchColumn();
	}

    public function execute(string $sql, array $params = [])
    {
        $result = $this->db->prepare($sql);
        foreach ($params as $key => &$value) {
            $result->bindParam(":$key", $value);
        }
        $result->execute();

        return $result;
    }
}
