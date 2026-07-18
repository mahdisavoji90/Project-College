<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
// ============================================
// شروع سشن
// ============================================
require_once(BASE_PATH . "/views/style.php");
// ============================================
// بررسی لاگین
// ============================================
if (!isset($_SESSION['user_id'])) {
    redirect(url('/login'));
    exit;
}

$user_id = $_SESSION['user_id'];

// ============================================
// دریافت اطلاعات کاربر
// ============================================
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect(url('/logout'));
    exit;
}

$user_name = htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name']));
if (empty($user_name)) {
    $user_name = explode('@', $user['email'])[0];
}
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) {
    $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);
}

// ============================================
// صفحه‌بندی
// ============================================
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 15;
$offset = ($page - 1) * $per_page;

// تعداد کل
$stmt = $db->prepare("SELECT COUNT(*) as total FROM transactions WHERE user_id = ?");
$stmt->execute([$user_id]);
$total = (int)$stmt->fetch()['total'];
$total_pages = ceil($total / $per_page);

// تراکنش‌ها
$stmt = $db->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $user_id, PDO::PARAM_INT);
$stmt->bindValue(2, $per_page, PDO::PARAM_INT);
$stmt->bindValue(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$type_labels = [
    'deposit'  => '💰 شارژ',
    'withdraw' => '🏧 برداشت',
    'purchase' => '🛒 خرید',
    'sale'     => '♻️ فروش',
    'reward'   => '🎁 پاداش',
    'fee'      => '📋 کارمزد'
];

$status_labels = [
    'success'  => 'موفق',
    'pending'  => 'در انتظار',
    'failed'   => 'ناموفق',
    'cancelled' => 'لغو شده'
];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تراکنش‌ها | بازیافت نوین</title>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- هدر -->
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
        <!-- سایدبار -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <div class="sidebar-avatar"><?= htmlspecialchars($user_initials) ?></div>
                <div class="sidebar-username"><?= htmlspecialchars($user_name) ?></div>
                <span class="sidebar-role">کاربر ویژه</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard"><span class="icon">📊</span> داشبورد</a></li>
                <li><a href="profile"><span class="icon">👤</span> پروفایل من</a></li>
                <li><a href="transactions" class="active"><span class="icon">💳</span> تراکنش‌ها</a></li>
                <li><a href="/baziaft234/request"><span class="icon">📝</span> درخواست‌ها</a></li>
                <li><a href="wallet"><span class="icon">💰</span> کیف پول</a></li>
                <li><a href="rewards"><span class="icon">⭐</span> امتیازات</a></li>
                <li><a href="addresses"><span class="icon">📍</span> آدرس‌ها</a></li>
                <li><a href="notifications"><span class="icon">🔔</span> اعلان‌ها</a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings"><span class="icon">⚙️</span> تنظیمات</a></li>
                <li><a href="logout" style="color: var(--danger);"><span class="icon">🚪</span> خروج</a></li>
                <li><a href="index" style="color: var(--primary);"><span class="icon">🏠</span> بازگشت به خانه</a></li>
            </ul>
        </aside>

        <!-- محتوای اصلی -->
        <main class="main-content">
            <div class="page-header">
                <h1>💳 تراکنش‌ها</h1>
                <p>لیست تمام تراکنش‌های مالی شما (<?= number_format($total) ?> مورد)</p>
            </div>

            <div class="card">
                <div class="table-container">
                    <?php if (count($transactions) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نوع</th>
                                <th>مبلغ (تومان)</th>
                                <th>توضیحات</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td><strong>#<?= $tx['id'] ?></strong></td>
                                <td><?= $type_labels[$tx['type']] ?? $tx['type'] ?></td>
                                <td><strong><?= number_format($tx['amount']) ?></strong></td>
                                <td><?= htmlspecialchars($tx['description'] ?? '—') ?></td>
                                <td><?= date('Y/m/d H:i', strtotime($tx['created_at'])) ?></td>
                                <td>
                                    <span class="status <?= htmlspecialchars($tx['status']) ?>">
                                        <?= $status_labels[$tx['status']] ?? $tx['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="empty-state">
                        <p>🎯 هنوز هیچ تراکنشی ثبت نشده.</p>
                        <p><a href="wallet.php">شارژ کیف پول</a> رو شروع کنید!</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- صفحه‌بندی -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="page-btn">« قبلی</a>
                    <?php endif; ?>
                    <span class="page-info">صفحه <?= $page ?> از <?= $total_pages ?></span>
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="page-btn">بعدی »</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
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