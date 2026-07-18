<?php
namespace App\Controllers;
class AdminController {
    public static function getStats($db) {
        return [
            'users' => $db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'requests' => $db->query("SELECT COUNT(*) FROM register_sell")->fetchColumn(),
            'prices' => $db->query("SELECT COUNT(*) FROM recycling_prices")->fetchColumn()
        ];
    }
}
