<?php

class Router
{
    protected $routes = [];

    public function any($uri, $controller)
    {
        $this->routes[] = ['uri' => $uri, 'controller' => $controller];
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri) {
                return require BASE_PATH . '/views/' . $route['controller'];
            }
        }
        echo "404 - صفحه پیدا نشد";
    }
}