<?php

try
{
    /**
     * Call the Psr4AutoloaderClass and load all namespaces in namespaces.php file
     */
    (function()
    {
        require 'components/Psr4AutoloaderClass.php';
        $ns_list = require 'config/namespaces.php';

        $loader = new app\components\Psr4AutoloaderClass();
        $loader->register();

        foreach ($ns_list as $item)
            $loader->addNamespace($item['namespace'], $item['path']);
    })();

    // General Settings
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    define('DEBUG', true);
    define('HOST_NAME', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}");
    session_start();

    // Call the Router
    $router = new app\components\Router(
        require 'config/routes.php',
        'app\\controllers\\',
        'action',
        'Controller');

    if (!$router->run())
        app\components\lib\Lib::view('views/error_pages/404.php');
}
catch (Exception $e)
{
    if (DEBUG)
        echo "<pre>$e</pre>";
    else
        app\components\lib\Lib::view('views/error_pages/500.php');
}
