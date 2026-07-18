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

// جدول آدرس‌ها
try {
    $db->exec("CREATE TABLE IF NOT EXISTS user_addresses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(100) NOT NULL COMMENT 'عنوان: منزل، محل کار و...',
        address TEXT NOT NULL,
        city VARCHAR(100) DEFAULT NULL,
        postal_code VARCHAR(20) DEFAULT NULL,
        is_default TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (Exception $e) {}

$message = '';
$message_type = '';

// حذف آدرس
if (isset($_POST['delete']) && isset($_POST['address_id'])) {
    $stmt = $db->prepare("DELETE FROM user_addresses WHERE id = ? AND user_id = ?");
    $stmt->execute([(int)$_POST['address_id'], $user_id]);
    $message = 'آدرس با موفقیت حذف شد.';
    $message_type = 'success';
}

// افزودن/ویرایش آدرس
if (isset($_POST['save'])) {
    $title = trim($_POST['title'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    $is_default = isset($_POST['is_default']) ? 1 : 0;
    $address_id = isset($_POST['address_id']) ? (int)$_POST['address_id'] : 0;

    if (empty($title) || empty($address)) {
        $message = 'عنوان و آدرس الزامی هستند.';
        $message_type = 'error';
    } else {
        if ($is_default) {
            $db->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?")->execute([$user_id]);
        }

        if ($address_id > 0) {
            $stmt = $db->prepare("UPDATE user_addresses SET title=?, address=?, city=?, postal_code=?, is_default=? WHERE id=? AND user_id=?");
            $stmt->execute([$title, $address, $city, $postal_code, $is_default, $address_id, $user_id]);
            $message = 'آدرس با موفقیت ویرایش شد.';
        } else {
            $stmt = $db->prepare("INSERT INTO user_addresses (user_id, title, address, city, postal_code, is_default) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $title, $address, $city, $postal_code, $is_default]);
            $message = 'آدرس جدید با موفقیت اضافه شد.';
        }
        $message_type = 'success';
    }
}

// لیست آدرس‌ها
$stmt = $db->prepare("SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC, created_at DESC");
$stmt->execute([$user_id]);
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آدرس‌ها | بازیافت نوین</title>
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
                <li><a href="addresses" class="active"><span class="icon">📍</span> آدرس‌ها</a></li>
                <li><a href="notifications"><span class="icon">🔔</span> اعلان‌ها</a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings"><span class="icon">⚙️</span> تنظیمات</a></li>
                <li><a href="/logout" style="color: var(--danger);"><span class="icon">🚪</span> خروج</a></li>
                <li><a href="/baziaft234" style="color: var(--primary);"><span class="icon">🏠</span> خانه</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>📍 آدرس‌های من</h1>
                <p>مدیریت آدرس‌های ثبت‌شده</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
            <?php endif; ?>

            <!-- لیست آدرس‌ها -->
            <?php if (count($addresses) > 0): ?>
                <?php foreach ($addresses as $addr): ?>
                <div class="card" style="margin-bottom: 12px; <?= $addr['is_default'] ? 'border-color: var(--primary);' : '' ?>">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3 style="margin-bottom: 4px;">
                                <?= htmlspecialchars($addr['title']) ?>
                                <?php if ($addr['is_default']): ?>
                                    <span style="background: var(--primary); color: white; padding: 2px 10px; border-radius: 12px; font-size: 0.7rem;">پیش‌فرض</span>
                                <?php endif; ?>
                            </h3>
                            <p style="color: var(--text-secondary);"><?= htmlspecialchars($addr['address']) ?></p>
                            <?php if ($addr['city']): ?>
                                <p style="color: var(--text-muted); font-size: 0.85rem;">🏙️ <?= htmlspecialchars($addr['city']) ?></p>
                            <?php endif; ?>
                            <?php if ($addr['postal_code']): ?>
                                <p style="color: var(--text-muted); font-size: 0.85rem;">📮 <?= htmlspecialchars($addr['postal_code']) ?></p>
                            <?php endif; ?>
                        </div>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="address_id" value="<?= $addr['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-outline" style="color: var(--danger); border-color: var(--danger); padding: 6px 14px; font-size: 0.8rem;">🗑️ حذف</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="card" style="text-align: center; padding: 40px;">
                <p style="font-size: 2rem;">📍</p>
                <p style="color: var(--text-secondary);">هنوز هیچ آدرسی ثبت نکردید.</p>
            </div>
            <?php endif; ?>

            <!-- فرم افزودن آدرس -->
            <div class="card">
                <div class="card-header"><h3>➕ افزودن آدرس جدید</h3></div>
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>عنوان <span class="required">*</span></label>
                            <input type="text" name="title" placeholder="مثلاً: منزل، محل کار" required
                                   style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;">
                        </div>
                        <div class="form-group">
                            <label>شهر</label>
                            <input type="text" name="city" placeholder="مثلاً: تهران"
                                   style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;">
                        </div>
                        <div class="form-group full-width">
                            <label>آدرس کامل <span class="required">*</span></label>
                            <textarea name="address" rows="2" placeholder="آدرس دقیق خود را وارد کنید" required
                                      style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;"></textarea>
                        </div>
                        <div class="form-group">
                            <label>کد پستی</label>
                            <input type="text" name="postal_code" placeholder="کد پستی ۱۰ رقمی"
                                   style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; color: var(--text-primary); width: 100%;">
                        </div>
                        <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" name="is_default" id="is_default" value="1" style="width: auto;">
                            <label for="is_default" style="margin: 0;">آدرس پیش‌فرض</label>
                        </div>
                    </div>
                    <button type="submit" name="save" class="btn btn-primary" style="margin-top: 12px;">💾 ذخیره آدرس</button>
                </form>
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