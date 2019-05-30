<?php

namespace app\components;

/**
 * Simple Router class
 * @author prippa
 */
class Router
{
    /**
     * @var array Routes
     */
    private $routes;

    /**
     * @var string Namespace of controller classes
     */
    private $namespace;

    /**
     * @var string Prefix of action methods
     */
    private $action_prefix;

    /**
     * @var string Postfix of controller classes
     */
    private $controller_postfix;

    /**
     * Router constructor.
     * @param array $routes
     * @param string $namespace
     * @param string $action_prefix
     * @param string $controller_postfix
     */
    public function __construct($routes, $namespace, $action_prefix, $controller_postfix)
    {
        $this->routes = $routes;
        $this->namespace = $namespace;
        $this->action_prefix = $action_prefix;
        $this->controller_postfix = $controller_postfix;
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
     * @return bool if route was found returns true otherwise false.
     */
    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uri_pattern => $path)
        {
            if (preg_match("~^$uri_pattern$~", $uri))
            {
                $internal_route = preg_replace("~$uri_pattern~", $path, $uri);

                $segments = explode('/', $internal_route);
                $controller_name = $this->namespace . ucfirst(array_shift($segments)) . $this->controller_postfix;
                $action_name = $this->action_prefix . ucfirst(array_shift($segments));

                $controller_object = new $controller_name;
                call_user_func_array(array($controller_object, $action_name), $segments);
                return true;
            }
        }
        return false;
    }
}
