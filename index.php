<?php

/**
 * Call the Psr4AutoloaderClass and announce all namespaces in namespaces.php file
 * @return void
 */
$auto_loader = function ()
{
    require ROOT . 'components/Psr4AutoloaderClass.php';
    $ns_list = require CONFIG . 'namespaces.php';

    $loader = new app\components\Psr4AutoloaderClass;
    $loader->register();

    foreach ($ns_list as $item)
        $loader->addNamespace($item['namespace'], $item['path']);
};

// 1. General Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', __DIR__ . '/');
define('CONFIG', ROOT . 'config/');
define('VIEWS', ROOT . 'views/');
define('CSS', '/css/');
define('BOOTSTRAP', CSS . 'bootstrap.min.css');

// 2. PSR-4 Auto Loader
$auto_loader();
unset($auto_loader);

// 3. Call the Router
$router = new app\components\Router(
    require CONFIG . 'routes.php',
    'app\\controllers\\',
    'action',
    'Controller');
if (!$router->run())
    echo 'Page Not Found!';
