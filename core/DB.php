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
        $dsn = "mysql:dbname={$settings['dbname']};host={$settings['host']}";

        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        $this->db = new PDO($dsn, $settings['user'], $settings['password'], $options);
    }

    public function insert(string $table, array $params): void
    {
        $fields = '';
        $values = '';
        $count = count($params);

        for ($i = 0; ($i + 1) < $count; $i += 2) {
            $key = $params[$i];
            $fields .= "$key,";
            $values .= ":$key,";
        }
        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $this->execute($sql, $params);
    }

    public function delete(string $table, array $where, ?int $limit = null): void
    {
        $where_string = $this->prepareWhere($where);
        $sql = "DELETE FROM $table WHERE $where_string";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $this->execute($sql, $where);
    }

    public function update(string $table, array $params, array $where, ?int $limit = null)
    {
        $setString = '';
        $where_string = $this->prepareWhere($where);
        $count = count($params);

        for ($i = 0; ($i + 1) < $count; $i += 2) {
            $key = $params[$i];
            $setString .= "$key = :$key,";
        }
        $setString = rtrim($setString, ',');
        $sql = "UPDATE $table SET $setString WHERE $where_string";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $params = array_merge($params, $where);
        $this->execute($sql, $params);
    }

    public function select(string $table, array $params = [], array $where = [], ?int $limit = null)
    {
        $sql = $this->prepareSelect($table, $params, $where);

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        return $this->execute($sql, $where);
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

    public function col(string $sql, array $params = [])
    {
		$result = $this->execute($sql, $params);
		return $result->fetchColumn();
	}

	public function selectCol(string $table, string $col, array $where = [])
    {
        $where_string = $this->prepareWhere($where);
        $sql = "SELECT $col FROM $table";
        if (!empty($where_string)) {
            $sql .= " WHERE $where_string";
        }
        $sql .= ' LIMIT 1';
        return $this->col($sql, $where);
    }

    public function selectRow(string $table, array $params = [], array $where = [])
    {
        $sql = $this->prepareSelect($table, $params, $where);
        $sql .= " LIMIT 1";

        return $this->row($sql, $where);
    }

    public function selectRows(string $table, array $params = [], array $where = [])
    {
        $sql = $this->prepareSelect($table, $params, $where);

        return $this->rows($sql, $where);
    }

    public function execute(string $sql, array $params = [])
    {
        $result = $this->db->prepare($sql);
        $count = count($params);

        for ($i = 0; ($i + 1) < $count; ++$i) {
            $result->bindParam(':' . $params[$i], $params[++$i]);
        }
        $result->execute();

        return $result;
    }

    private function prepareWhere(array &$where): string
    {
        $where_string = '';
        $count = count($where);

        for ($i = 0; ($i + 1) < $count; $i += 2) {
            $key = $where[$i];
            $where_string .= "$key = :w$key AND ";
            $where[$i] = "w$key";
        }
        $where_string = rtrim($where_string, ' AND ');

        return $where_string;
    }

    private function prepareSelect(string $table, array &$params, array &$where)
    {
        $params_string = '';
        $where_string = $this->prepareWhere($where);

        foreach ($params as $param) {
            $params_string .= "$param,";
        }
        $params_string = rtrim($params_string, ',');
        $sql = 'SELECT';
        $sql .= (empty($params_string) ? ' *' : " $params_string");
        $sql .= " FROM $table";
        if (!empty($where_string)) {
            $sql .= " WHERE $where_string";
        }

        return $sql;
    }
}
