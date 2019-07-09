<?php

/**
 * Call the Psr4AutoloaderClass and load all namespaces in namespaces.php file
 */
$auto_loader = function() : void
{
    require 'components/Psr4AutoloaderClass.php';
    $ns_list = require 'config/namespaces.php';

    $loader = new app\components\Psr4AutoloaderClass();
    $loader->register();

    foreach ($ns_list as $item)
        $loader->addNamespace($item['namespace'], $item['path']);
};

// 1. General Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. PSR-4 Auto Loader
$auto_loader();
unset($auto_loader);

// 3. Start Session
session_start();

// 4. Call the Router
$router = new app\components\Router(
    require 'config/routes.php',
    'app\\controllers\\',
    'action',
    'Controller');

if (!$router->run())
    echo 'Page Not Found!';
