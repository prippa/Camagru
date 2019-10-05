<?php

try {
    // General Settings
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    define('DEBUG', true);
    define('HOST_NAME', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}");
    define('UPLOADS', 'uploads/');
    define('UPLOADS_DIR', __DIR__ . UPLOADS);

    /**
     * Call the Psr4AutoloaderClass and load all namespaces in namespaces.php file
     */
    (function() {
        require 'components/Psr4AutoloaderClass.php';
        $ns_list = require 'config/namespaces.php';

        $loader = new app\components\Psr4AutoloaderClass();
        $loader->register();

        foreach ($ns_list as $item) {
            $loader->addNamespace($item['namespace'], $item['path']);
        }
    })();

    // Call the Router
    $router = new app\components\lib\Router(
        require 'config/routes.php',
        'app\\controllers\\',
        'action',
        'Controller');

    if (!$router->run()) {
        app\views\View::run(app\views\View::ERROR_404);
    }
} catch (Exception $e) {
    if (DEBUG) {
        echo "<pre style='color: red; font-size: 16px;'>". $e. "</pre>";
    } else {
        app\views\View::run(app\views\View::ERROR_500);
    }
}
