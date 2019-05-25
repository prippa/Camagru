<?php

/**
 * Call the Psr4AutoloaderClass and announce all namespaces in namespaces.php file
 * @return void
 */
$autoLoader = function ()
{
    require ROOT . 'components/Psr4AutoloaderClass.php';
    $nsList = require ROOT . 'config/namespaces.php';

    $loader = new app\components\Psr4AutoloaderClass;
    $loader->register();

    foreach ($nsList as $item) {
        $loader->addNamespace($item['namespace'], $item['path']);
    }
};

// 1. General Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', __DIR__ . '/');

// 2. PSR-4 Auto Loader
$autoLoader();
unset($autoLoader);

// 3. Call the Router
$router = new app\components\Router();
if (!$router->run())
    echo 'Page Not Found!';
