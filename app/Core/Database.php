<?php

namespace App\Core;

use PDO;
use Exception;

class Database
{
    private static $instance = null;

    public static function connection($config)
    {
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
                self::$instance = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (Exception $e) {
                die("خطا در اتصال به دیتابیس: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}