<?php
// فایل کمکی برای اطمینان از دسترسی $db در view ها
if (!isset($db) && isset($GLOBALS['db'])) {
    $db = $GLOBALS['db'];
}
