<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once __DIR__ . "/inc_db.php";
if(!isset($_SESSION['admin_id'])){
    redirect(url('/admin/login'));
    exit;
}

// حذف کاربر
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    redirect(url('/admin/users'));
    exit;
}

// ویرایش کاربر
if(isset($_POST['edit'])){
    $id = (int)$_POST['id'];
    $email = trim($_POST['email']);
    
    if(!empty($_POST['new_password'])){
        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $db->prepare("UPDATE users SET email = ?, password = ? WHERE id = ?")->execute([$email, $password, $id]);
    } else {
        $db->prepare("UPDATE users SET email = ? WHERE id = ?")->execute([$email, $id]);
    }
    
    redirect(url('/admin/users'));
    exit;
}

$users = $db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مدیریت کاربران</title>
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
    max-width: 1200px; 
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

.edit-btn { 
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white; 
    padding: 7px 18px; 
    border-radius: 6px; 
    text-decoration: none; 
    font-size: 13px;
    margin-left: 5px;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
    font-weight: 500;
}

.edit-btn:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.5);
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

.modal { 
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    align-items: center; 
    justify-content: center;
    z-index: 1000;
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.modal-content { 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 35px; 
    border-radius: 15px; 
    width: 90%; 
    max-width: 500px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px 15px 0 0;
}

.modal-content h2 {
    color: #e2e8f0;
    margin-bottom: 20px;
    font-size: 22px;
}

.modal-content input { 
    width: 100%; 
    padding: 12px 15px; 
    margin: 10px 0; 
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    background: rgba(15, 23, 42, 0.5);
    color: #e2e8f0;
    font-size: 14px;
    transition: all 0.3s ease;
}

.modal-content input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    background: rgba(15, 23, 42, 0.7);
}

.modal-content input::placeholder {
    color: #94a3b8;
}

.modal-content button { 
    padding: 12px 24px; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white; 
    border: none; 
    border-radius: 8px; 
    cursor: pointer; 
    margin-left: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.modal-content button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.close-modal { 
    background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
}

.close-modal:hover {
    background: linear-gradient(135deg, #475569 0%, #334155 100%);
    box-shadow: 0 6px 20px rgba(100, 116, 139, 0.5);
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
    
    .edit-btn, .delete-btn {
        padding: 5px 12px;
        font-size: 11px;
        margin: 2px;
    }
    
    .modal-content {
        padding: 25px;
        width: 95%;
    }
}
</style>
</head>
<body>
    <div class="header">
        <h1>👥 مدیریت کاربران</h1>
        <a href="/baziaft234/admin" class="back">بازگشت به داشبورد</a>
    </div>
    
   <div class="container">
    <table>
        <thead>
            <tr>
                <th>شناسه</th>
                <th>تصویر</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>ایمیل</th>
                <th>تلفن</th>
                <th>سطح کاربری</th>
                <th>امتیاز</th>
                <th>کیف پول</th>
                <th>تاریخ عضویت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>

                <td>
                    <?php if(!empty($user['profile_picture'])): ?>
                        <img src="<?= htmlspecialchars($user['profile_picture']) ?>"
                             width="50"
                             height="50"
                             style="border-radius:50%;object-fit:cover;">
                    <?php else: ?>
                        <span>ندارد</span>
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($user['first_name']) ?></td>

                <td><?= htmlspecialchars($user['last_name']) ?></td>

                <td><?= htmlspecialchars($user['email']) ?></td>

                <td><?= htmlspecialchars($user['phone']) ?></td>

                <td><?= htmlspecialchars($user['user_level']) ?></td>

                <td><?= number_format($user['total_points']) ?></td>

                <td><?= number_format($user['wallet_balance']) ?> تومان</td>

                <td><?= $user['created_at'] ?></td>

                <td>
                    <a href="#"
                       class="edit-btn"
                       onclick="openEditModal(
                           <?= $user['id'] ?>,
                           '<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>'
                       )">
                        ویرایش
                    </a>

                    <a href="?delete=<?= $user['id'] ?>"
                       class="delete-btn"
                       onclick="return confirm('آیا مطمئن هستید؟')">
                        حذف
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
    
    <!-- Modal ویرایش -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>ویرایش کاربر</h2>
            <form method="POST">
                <input type="hidden" name="id" id="edit_id">
                <input type="email" name="email" id="edit_email" placeholder="ایمیل" required>
                <input type="password" name="new_password" placeholder="رمز عبور جدید (اختیاری)">
                <button type="submit" name="edit">ذخیره</button>
                <button type="button" class="close-modal" onclick="closeEditModal()">انصراف</button>
            </form>
        </div>
    </div>
    
    <script>
        function openEditModal(id, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_email').value = email;
            document.getElementById('editModal').style.display = 'flex';
        }
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>
</html>
