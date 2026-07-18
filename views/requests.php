<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// شروع سشن
// ============================================
// ============================================
// اتصال به دیتابیس
// ============================================
// ============================================
// بررسی لاگین
// ============================================
if (!isset($_SESSION['user_id'])) {
    redirect(url('/login'));
    exit;
}

// ============================================
// دریافت اطلاعات کاربر
// ============================================
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect(url('/logout'));
    exit;
}

$user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) {
    $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);
}

// ============================================
// دریافت لیست انواع بازیافت
// ============================================
$recycling_types = [];
$stmt = $db->query("SELECT * FROM recycling ORDER BY name");
$recycling_types = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================================
// دریافت لیست درخواست‌ها
// ============================================
$page_num = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page_num - 1) * $per_page;

$status_filter = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';

$where_conditions = ["r.users_id = ?"];
$params = [$user_id];

if ($status_filter !== 'all') {
    $where_conditions[] = "r.status = ?";
    $params[] = $status_filter;
}

if (!empty($search)) {
    $where_conditions[] = "(r.description LIKE ? OR r.numberphone LIKE ? OR r.tracking_code LIKE ? OR rec.name LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

$where_clause = implode(" AND ", $where_conditions);

// ============================================
// تعداد کل
// ============================================
$count_stmt = $db->prepare("
    SELECT COUNT(*) FROM register_sell r 
    LEFT JOIN recycling rec ON r.recyclingtype_id = rec.id 
    WHERE $where_clause
");
$count_stmt->execute($params);
$total_requests = $count_stmt->fetchColumn();
$total_pages = ceil($total_requests / $per_page);

// ============================================
// دریافت درخواست‌ها - روش اصلاح شده
// ============================================
// راه حل 1: استفاده از bindValue با PDO::PARAM_INT
$stmt = $db->prepare("
    SELECT 
        r.*,
        rec.name as recycling_name,
        rec.price_per_kg,
        rec.image as recycling_image
    FROM register_sell r 
    LEFT JOIN recycling rec ON r.recyclingtype_id = rec.id 
    WHERE $where_clause 
    ORDER BY r.created_at DESC 
    LIMIT ? OFFSET ?
");

// پارامترها رو به صورت جداگانه bind کنید
$param_index = 1;
foreach ($params as $param) {
    $stmt->bindValue($param_index, $param);
    $param_index++;
}

// LIMIT و OFFSET رو با PDO::PARAM_INT bind کنید
$stmt->bindValue($param_index, $per_page, PDO::PARAM_INT);
$param_index++;
$stmt->bindValue($param_index, $offset, PDO::PARAM_INT);

$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================================
// پردازش درخواست جدید
// ============================================
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_request') {
    $recyclingtype_id = (int)$_POST['recyclingtype_id'];
    $weight = (int)$_POST['weight'];
    $description = trim($_POST['description'] ?? '');
    $numberphone = trim($_POST['numberphone'] ?? '');
    
    if (empty($recyclingtype_id) || $recyclingtype_id < 1) {
        $error_message = 'لطفاً نوع بازیافت را انتخاب کنید';
    } elseif ($weight < 1) {
        $error_message = 'وزن باید بیشتر از 0 باشد';
    } elseif (empty($description)) {
        $error_message = 'توضیحات الزامی است';
    } elseif (!empty($numberphone) && !preg_match('/^09[0-9]{9}$/', $numberphone)) {
        $error_message = 'شماره تماس نامعتبر است';
    } else {
        $tracking_code = 'REQ-' . strtoupper(uniqid()) . '-' . date('Ymd');
        
        $stmt = $db->prepare("
            INSERT INTO register_sell 
            (recyclingtype_id, weight, description, numberphone, users_id, status, tracking_code, created_at)
            VALUES (?, ?, ?, ?, ?, 'pending', ?, NOW())
        ");
        
        if ($stmt->execute([$recyclingtype_id, $weight, $description, $numberphone, $user_id, $tracking_code])) {
            $success_message = '✅ درخواست فروش با موفقیت ثبت شد! کد پیگیری: ' . $tracking_code;
            echo "<meta http-equiv='refresh' content='2'>";
        } else {
            $error_message = '❌ خطا در ثبت درخواست';
        }
    }
}

// ============================================
// پردازش لغو درخواست
// ============================================
if (isset($_GET['cancel']) && is_numeric($_GET['cancel'])) {
    $request_id = (int)$_GET['cancel'];
    $stmt = $db->prepare("
        UPDATE register_sell 
        SET status = 'cancelled', updated_at = NOW() 
        WHERE id = ? AND users_id = ? AND status IN ('pending', 'in_progress')
    ");
    if ($stmt->execute([$request_id, $user_id])) {
        $success_message = '✅ درخواست با موفقیت لغو شد';
        redirect(url('/requests?success=1'));
        exit;
    }
}

$page = "requests";
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درخواست‌های فروش - بازیافت نوین</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<!-- <?php // require_once ('request_detail.php') ?> -->
<!-- ادامه کد HTML شما... -->

</body>
</html>