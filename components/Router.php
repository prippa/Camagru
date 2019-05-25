<?php

namespace app\components;

class Router
{
    /**
     * Routes array
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = require ROOT . '/config/routes.php';
    }

    /**
     * Returns request uri
     * @return string
     */
    private function getURI()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    /**
     * Find the valid route, create the associated controller class and call the action method
     * @return bool
     */
    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);
                $controllerName = 'app\controllers\\' . ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));

                $controllerObject = new $controllerName;
                call_user_func_array(array($controllerObject, $actionName), $segments);
                return true;
            }
        }
        return false;
    }
}
