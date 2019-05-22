<?php

/**
 * Call the Psr4AutoloaderClass and announce all namespaces in namespaces.php file
 * @return void
 */
function autoLoader()
{
    require ROOT . 'config/Psr4AutoloaderClass.php';
    $nsList = require  ROOT . 'config/namespaces.php';

    $loader = new Example\Psr4AutoloaderClass;
    $loader->register();

    foreach ($nsList as $item) {
        $loader->addNamespace($item['namespace'], ROOT . $item['path']);
    }
}

// 1. General Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', __DIR__ . '/');

// 2. PSR-4 Auto Loader
autoLoader();

// 3. Call the Router
$router = new app\components\Router();
$router->run();
