<?php

try {
    // General Settings
    session_start();
    define('DEBUG', true);
    ini_set('display_errors', DEBUG);
    error_reporting(E_ALL);

    /**
     * Call the Psr4AutoloaderClass and load all namespaces in namespaces.php file
     */
    (function () {
        require 'components/Psr4AutoloaderClass.php';
        $ns_list = require 'config/namespaces.php';

        $loader = new app\components\Psr4AutoloaderClass();
        $loader->register();

        foreach ($ns_list as $item) {
            $loader->addNamespace($item['namespace'], $item['path']);
        }
    })();

    // Call the Router
    $router = new app\core\Router(
        require 'config/routes.php',
        'app\\controllers\\',
        'action',
        'Controller'
    );

    if (!$router->run()) {
        (new app\core\View())->run('error_pages/404');
    }
} catch (Exception $e) {
    if (DEBUG) {
        echo "<pre style='color: red; font-size: 16px;'>" . $e . "</pre>";
    } else {
        (new app\core\View())->run('error_pages/500');
    }
}
