<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once(BASE_PATH . "/views/style.php");
if (!isset($_SESSION['user_id'])) {
    redirect(url('/login'));
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) { redirect(url('/logout')); exit; }

$user_name = htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name']));
if (empty($user_name)) $user_name = explode('@', $user['email'])[0];
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);

$message = '';
$message_type = '';

// تغییر رمز عبور
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($current) || empty($new) || empty($confirm)) {
        $message = 'لطفاً تمام فیلدها را پر کنید.';
        $message_type = 'error';
    } elseif ($new !== $confirm) {
        $message = 'رمز عبور جدید و تکرار آن یکسان نیستند.';
        $message_type = 'error';
    } elseif (strlen($new) < 6) {
        $message = 'رمز عبور جدید باید حداقل ۶ کاراکتر باشد.';
        $message_type = 'error';
    } elseif (!password_verify($current, $user['password'])) {
        $message = 'رمز عبور فعلی اشتباه است.';
        $message_type = 'error';
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $user_id]);
        $message = '✅ رمز عبور با موفقیت تغییر کرد.';
        $message_type = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنظیمات | بازیافت نوین</title>
</head>
<body>

<div class="dashboard-wrapper">
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <div class="logo-icon">♻️</div>
                <span class="logo-text">بازیافت نوین</span>
            </div>
            <div class="header-right">
                <span class="date"><?= date('Y/m/d') ?></span>
                <div class="user-profile-btn" id="sidebarToggleBtn">
                    <span class="user-name"><?= htmlspecialchars($user_name) ?></span>
                    <div class="user-avatar"><?= htmlspecialchars($user_initials) ?></div>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-body">
        <aside class="sidebar">
            <div class="sidebar-user">
                <div class="sidebar-avatar"><?= htmlspecialchars($user_initials) ?></div>
                <div class="sidebar-username"><?= htmlspecialchars($user_name) ?></div>
                <span class="sidebar-role">کاربر ویژه</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard"><span class="icon">📊</span> داشبورد</a></li>
                <li><a href="profile"><span class="icon">👤</span> پروفایل من</a></li>
                <li><a href="transactions"><span class="icon">💳</span> تراکنش‌ها</a></li>
                <li><a href="/baziaft234/request"><span class="icon">📝</span> درخواست‌ها</a></li>
                <li><a href="wallet"><span class="icon">💰</span> کیف پول</a></li>
                <li><a href="rewards"><span class="icon">⭐</span> امتیازات</a></li>
                <li><a href="addresses"><span class="icon">📍</span> آدرس‌ها</a></li>
                <li><a href="notifications"><span class="icon">🔔</span> اعلان‌ها</a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings" class="active"><span class="icon">⚙️</span> تنظیمات</a></li>
                <li><a href="logout" style="color: var(--danger);"><span class="icon">🚪</span> خروج</a></li>
                <li><a href="index" style="color: var(--primary);"><span class="icon">🏠</span> خانه</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>⚙️ تنظیمات</h1>
                <p>مدیریت تنظیمات حساب کاربری</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
            <?php endif; ?>

            <!-- تغییر رمز عبور -->
            <div class="card">
                <div class="card-header"><h3>🔒 تغییر رمز عبور</h3></div>
                <form method="POST">
                    <input type="hidden" name="change_password" value="1">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>رمز عبور فعلی</label>
                            <input type="password" name="current_password" required
                                   style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;">
                        </div>
                        <div class="form-group full-width"></div>
                        <div class="form-group">
                            <label>رمز عبور جدید</label>
                            <input type="password" name="new_password" minlength="6" required
                                   style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;">
                        </div>
                        <div class="form-group">
                            <label>تکرار رمز جدید</label>
                            <input type="password" name="confirm_password" minlength="6" required
                                   style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 16px;">🔒 تغییر رمز عبور</button>
                </form>
            </div>

            <!-- اطلاعات حساب -->
            <div class="card">
                <div class="card-header"><h3>📋 اطلاعات حساب</h3></div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">ایمیل</span>
                        <span class="info-value"><?= htmlspecialchars($user['email']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">نام</span>
                        <span class="info-value"><?= htmlspecialchars($user_name) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">تلفن</span>
                        <span class="info-value"><?= htmlspecialchars($user['phone'] ?? '—') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">تاریخ ثبت‌نام</span>
                        <span class="info-value"><?= date('Y/m/d', strtotime($user['created_at'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">سطح کاربری</span>
                        <span class="info-value"><?= htmlspecialchars($user['user_level'] ?? 'bronze') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">آخرین بروزرسانی</span>
                        <span class="info-value"><?= date('Y/m/d H:i', strtotime($user['updated_at'])) ?></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
const sidebarBtn = document.getElementById('sidebarToggleBtn');
const sidebar = document.getElementById('profileSidebar');
const overlay = document.getElementById('sidebarOverlay');
if (sidebarBtn) {
    sidebarBtn.addEventListener('click', function() {
        if (sidebar) sidebar.classList.toggle('active');
        if (overlay) overlay.classList.toggle('active');
    });
}
if (overlay) {
    overlay.addEventListener('click', function() {
        if (sidebar) sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
}
</script>

</body>
</html>