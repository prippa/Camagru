<?php

define('DB_DSN', 'mysql:host=localhost;dbname=example01');
define('DB_USER', 'root');
define('DB_PASSWORD', 'prippa');

try {
    $db = new PDO(DB_DSN, DB_USER, DB_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    echo 'The connection failed: ' . $e->getMessage();
    exit;
}
