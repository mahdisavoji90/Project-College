<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
session_destroy();
header("Location: index.php");
exit;