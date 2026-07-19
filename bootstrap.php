<?php

declare(strict_types=1);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', 'D:/xampp/htdocs/baziaft234');
}


if (!defined('APP_BASE_URL')) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    if (str_contains($scriptName, '/adm/')) {
        $baseUrl = dirname(dirname($scriptName));
    } else {
        $baseUrl = dirname($scriptName);
    }
    $baseUrl = str_replace('\\', '/', $baseUrl);
    define('APP_BASE_URL', $baseUrl === '/' || $baseUrl === '.' ? '' : rtrim($baseUrl, '/'));
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_start();

require_once BASE_PATH . '/app/Core/Database.php';

use App\Core\Database;

$databaseConfig = require BASE_PATH . '/config/database.php';
$db = Database::connection($databaseConfig);
$GLOBALS['db'] = $db;

if (!function_exists('url')) {
    function url(string $path = '/'): string
    {
        return APP_BASE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('require_user')) {
    function require_user(): int
    {
        if (!isset($_SESSION['user_id'])) {
            redirect(url('/login'));
        }

        return (int) $_SESSION['user_id'];
    }
}

if (!function_exists('require_admin')) {
    function require_admin(): int
    {
        if (!isset($_SESSION['admin_id'])) {
            redirect(url('/admin/login'));
        }

        return (int) $_SESSION['admin_id'];
    }
}
