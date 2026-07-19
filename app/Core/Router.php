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
        // حذف query string از آدرس درخواستی
        $uriPath = (string) parse_url($uri, PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uriPath) {
                return require BASE_PATH . '/views/' . $route['controller'];
            }
        }
        
        http_response_code(404);
        echo "404 - صفحه پیدا نشد";
    }
}
