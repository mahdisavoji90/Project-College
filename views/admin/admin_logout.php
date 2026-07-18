<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once __DIR__ . "/inc_db.php";
session_destroy();
redirect(url('/admin/login'));
exit;
