<?php

define('ROOT', __DIR__ . '/');

$db_settings = require ROOT . 'database.php';
$DROP_IF_EXIST = 'DROP DATABASE IF EXISTS ' . $db_settings['dbname'];
$CREATE_DB = 'CREATE DATABASE ' . $db_settings['dbname'] . ' CHARACTER SET utf8 COLLATE utf8_general_ci';
$USE_DB = 'USE ' . $db_settings['dbname'];

try
{
    $db = new PDO('mysql:host=' . $db_settings['host'], $db_settings['user'], $db_settings['password']);
    $db->query($DROP_IF_EXIST);
    $db->query($CREATE_DB);
    $db->query($USE_DB);
    $sql = file_get_contents(ROOT . $db_settings['dbname'] . '.sql');
    $db->query($sql);
}
catch (PDOException $e)
{
    echo $e . PHP_EOL;
}

echo 'Database IS ALIVE!!!';
