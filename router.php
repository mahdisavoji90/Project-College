<?php

declare(strict_types=1);

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/router.php');
$baseUrl = dirname($scriptName);
define('APP_BASE_URL', $baseUrl === '/' || $baseUrl === '.' ? '' : rtrim($baseUrl, '/'));

require_once __DIR__ . '/bootstrap.php';
require_once BASE_PATH . '/app/Core/Router.php';

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = (string) parse_url($uri, PHP_URL_PATH);
if (APP_BASE_URL !== '' && str_starts_with($path, APP_BASE_URL)) {
    $path = substr($path, strlen(APP_BASE_URL)) ?: '/';
}
$query = parse_url($uri, PHP_URL_QUERY);
$routeUri = $path . ($query ? '?' . $query : '');

$router = new Router();
require BASE_PATH . '/routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $routeUri);
