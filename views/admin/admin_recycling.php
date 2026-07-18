<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once __DIR__ . "/inc_db.php";
if(!isset($_SESSION['admin_id'])) { redirect(url('/admin/login')); }

$message = '';
$error = '';

// مدیریت فرم CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $type = trim($_POST['type_name']);
        $price = (int)$_POST['price'];
        if ($type && $price > 0) {
            $stmt = $db->prepare("INSERT INTO recycling_prices (type_name, price) VALUES (?, ?)");
            $stmt->execute([$type, $price]);
            $message = "قیمت با موفقیت اضافه شد.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $db->prepare("DELETE FROM recycling_prices WHERE id = ?")->execute([$id]);
        $message = "قیمت با موفقیت حذف شد.";
    } elseif (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $price = (int)$_POST['price'];
        $db->prepare("UPDATE recycling_prices SET price = ? WHERE id = ?")->execute([$price, $id]);
        $message = "قیمت با موفقیت بروزرسانی شد.";
    }
}

$prices = $db->query("SELECT * FROM recycling_prices ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت قیمت ضایعات</title>
    <style>
        body { font-family: Tahoma, sans-serif; background: #0f172a; color: #e2e8f0; padding: 20px; }
        .card { background: #1e293b; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; color: #fff; }
        th, td { padding: 12px; border: 1px solid #334155; text-align: center; }
        input { padding: 8px; border-radius: 6px; border: 1px solid #475569; background: #0f172a; color: #fff; }
        .btn { padding: 8px 16px; border-radius: 6px; cursor: pointer; border: none; }
        .btn-add { background: #10b981; color: white; }
        .btn-delete { background: #ef4444; color: white; }
    </style>
</head>
<body>
    <div class="card">
        <h2>افزودن قیمت جدید</h2>
        <form method="POST">
            <input type="text" name="type_name" placeholder="نوع ضایعات" required>
            <input type="number" name="price" placeholder="قیمت (تومان)" required>
            <button type="submit" name="add" class="btn btn-add">افزودن</button>
        </form>
        
    </div>
 <div class="header">
        <h1>📋 مدیریت درخواست‌های فروش</h1>
        <a href="/baziaft234/admin" class="back">بازگشت به داشبورد</a>
    </div>
    
    <div class="card">
        <h2>لیست قیمت‌ها</h2>
        <table>
            <tr><th>نوع</th><th>قیمت</th><th>عملیات</th></tr>
            <?php foreach ($prices as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['type_name']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="number" name="price" value="<?= $row['price'] ?>">
                        <button type="submit" name="update" class="btn">ویرایش</button>
                    </form>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete" class="btn btn-delete">حذف</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>