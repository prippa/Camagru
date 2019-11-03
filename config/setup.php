<?php

define('ROOT', __DIR__ . '/');

// Init DB
$db_settings = require ROOT . 'database.php';
$DROP_IF_EXIST = 'DROP DATABASE IF EXISTS ' . $db_settings['dbname'];
$CREATE_DB = 'CREATE DATABASE ' . $db_settings['dbname'] . ' CHARACTER SET utf8 COLLATE utf8_general_ci';
$USE_DB = 'USE ' . $db_settings['dbname'];

try {
    $db = new PDO('mysql:host=' . $db_settings['host'], $db_settings['user'], $db_settings['password']);
    $db->query($DROP_IF_EXIST);
    $db->query($CREATE_DB);
    $db->query($USE_DB);
    $sql = file_get_contents(ROOT . $db_settings['dbname'] . '.sql');
    $db->query($sql);
    echo 'Database IS ALIVE!!!' . PHP_EOL;
} catch (PDOException $e) {
    echo $e . PHP_EOL;
}

// Create folder for uploaded images
$dir = ROOT . '../uploads';
if (!file_exists($dir)) {
    mkdir($dir);
    echo 'uploads dir is created!' . PHP_EOL;
} else {
    echo 'uploads dir creation failed!' . PHP_EOL;
}
