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

    public function insert(string $table, array $params): void
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

    public function delete(string $table, array $where, ?int $limit = 1): void
    {
        $whereString = $this->prepareWhere($where);
        $sql = "DELETE FROM $table WHERE $whereString";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $this->execute($sql, $where);
    }

    public function update(string $table, array $params, array $where, ?int $limit = 1)
    {
        $setString = '';
        $whereString = $this->prepareWhere($where);

        foreach ($params as $field) {
            $setString .= "$field = :$field,";
        }
        $setString = rtrim($setString, ',');
        $sql = "UPDATE $table SET $setString WHERE $whereString";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $params = array_merge($params, $where);
        $this->execute($sql, $params);
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

    public function selectRow(string $table, int $id, array $params = [])
    {
        $paramsString = '';

        foreach ($params as $field) {
            $paramsString .= "$field,";
        }
        $paramsString = rtrim($paramsString, ',');
        $sql = "SELECT $paramsString FROM $table WHERE id = $id LIMIT 1";
        return $this->row($sql, $params);
    }

    public function selectRows(string $table, int $id, array $params = [])
    {
        $paramsString = '';

        foreach ($params as $field) {
            $paramsString .= "$field,";
        }
        $paramsString = rtrim($paramsString, ',');
        $sql = "SELECT $paramsString FROM $table WHERE id = $id";
        return $this->rows($sql, $params);
    }

    public function col(string $sql, array $params = [])
    {
		$result = $this->execute($sql, $params);
		return $result->fetchColumn();
	}

	public function selectCol(string $table, int $id, string $col)
    {
        $sql = "SELECT $col FROM $table WHERE id = $id LIMIT 1";
        return $this->col($sql);
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

    private function prepareWhere(array & $where): string
    {
        $whereString = '';

        foreach ($where as $key) {
            $whereString .= "$key = :w$key AND ";
            $where["w$key"] = $where[$key];
            unset($where[$key]);
        }
        $whereString = rtrim($whereString, ' AND ');
        return $whereString;
    }
}
