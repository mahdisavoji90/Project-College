<?php
/** @var Router $router */
$router->any('/', 'index.php');
$router->any('/login', 'login.php');
$router->any('/logout', 'logout.php');
$router->any('/dashboard', 'dashboard.php');
$router->any('/profile', 'profile.php');
$router->any('/settings', 'settings.php');
$router->any('/addresses', 'addresses.php');
$router->any('/requests', 'requests.php');
$router->any('/request', 'request_detail.php');
$router->any('/transactions', 'transactions.php');
$router->any('/wallet', 'wallet.php');
$router->any('/rewards', 'rewards.php');
$router->any('/notifications', 'notifications.php');

$router->any('/admin/login', 'admin/admin_login.php');
$router->any('/admin/logout', 'admin/admin_logout.php');
$router->any('/admin', 'admin/admin_dashboard.php');
$router->any('/admin/users', 'admin/admin_users.php');
$router->any('/admin/recycling', 'admin/admin_recycling.php');
$router->any('/admin/requests', 'admin/admin_sell_requests.php');
