<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once __DIR__ . "/inc_db.php";
if(!isset($_SESSION['admin_id'])){
    redirect(url('/admin/login'));
    exit;
}

// حذف درخواست
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $db->prepare("DELETE FROM register_sell WHERE id = ?")->execute([$id]);
    redirect(url('/admin/requests'));
    exit;
}

// دریافت لیست درخواست‌ها
$stmt = $db->query("
    SELECT rs.*, u.email, r.recyclingtype 
    FROM register_sell rs
    LEFT JOIN users u ON rs.users_id = u.id
    LEFT JOIN recycling r ON rs.recyclingtype_id = r.id
    ORDER BY rs.id DESC
");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت درخواست‌های فروش</title>
    <style>
     * { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
}

body { 
    font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
}

body::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.15) 0%, transparent 70%);
    top: -250px;
    right: -250px;
    border-radius: 50%;
    pointer-events: none;
}

.header { 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white; 
    padding: 25px 30px; 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.header::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

.header h1 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 24px;
    font-weight: 600;
}

.back { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white; 
    padding: 10px 24px; 
    border-radius: 8px; 
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.back:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.container { 
    max-width: 1400px; 
    margin: 30px auto; 
    padding: 0 20px; 
}

table { 
    width: 100%; 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    border-radius: 15px; 
    overflow: hidden; 
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

th, td { 
    padding: 18px 20px; 
    text-align: right; 
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    color: #e2e8f0;
}

th { 
    background: linear-gradient(135deg, #334155 0%, #475569 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.5px;
}

tr:hover {
    background: rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
}

.delete-btn { 
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white; 
    padding: 7px 18px; 
    border-radius: 6px; 
    text-decoration: none; 
    font-size: 13px;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
    font-weight: 500;
}

.delete-btn:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.5);
}

@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .container {
        padding: 0 10px;
    }
    
    table {
        font-size: 14px;
    }
    
    th, td {
        padding: 12px 10px;
    }
}
</style>
</head>
<body>
    <div class="header">
        <h1>📋 مدیریت درخواست‌های فروش</h1>
        <a href="/baziaft234/admin" class="back">بازگشت به داشبورد</a>
    </div>
    
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>شناسه</th>
                    <th>ایمیل کاربر</th>
                    <th>نوع ضایعات</th>
                    <th>وزن (کیلوگرم)</th>
                    <th>توضیحات</th>
                    <th>شماره تماس</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($requests as $req): ?>
                <tr>
                    <td><?= $req['id'] ?></td>
                    <td><?= htmlspecialchars($req['email'] ?? 'نامشخص') ?></td>
                    <td><?= htmlspecialchars($req['recyclingtype'] ?? 'نامشخص') ?></td>
                    <td><?= $req['weight'] ?></td>
                    <td><?= htmlspecialchars($req['description']) ?></td>
                    <td><?= htmlspecialchars($req['numberphone']) ?></td>
                    <td>
                        <a href="?delete=<?= $req['id'] ?>" class="delete-btn" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
