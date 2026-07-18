<?php

declare(strict_types=1);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}

require_once __DIR__ . '/bootstrap.php';
require_once BASE_PATH . '/app/Core/Router.php';

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = (string) parse_url($uri, PHP_URL_PATH);


$base = '/baziaft234';
if (str_starts_with($path, $base)) {
    $path = substr($path, strlen($base));
}
if ($path === '' || $path === false) $path = '/';

$router = new Router();
require BASE_PATH . '/routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], $path);