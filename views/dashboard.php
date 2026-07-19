<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once(BASE_PATH . "/views/style.php");

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

$user_id = $_SESSION['user_id'];

// ============================================
// دریافت اطلاعات کاربر
// ============================================
try {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $user = null;
}

if (!$user) {
    redirect(url('/logout'));
    exit;
}

// متغیرهای کاربر
$user_name = htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name']));
if (empty($user_name)) {
    $user_name = explode('@', $user['email'])[0];
}
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) {
    $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);
}

// ============================================
// آمار واقعی از دیتابیس
// ============================================

// موجودی کیف پول
$wallet_balance = (int)($user['wallet_balance'] ?? 0);

// تعداد کل تراکنش‌ها
$stmt = $db->prepare("SELECT COUNT(*) as total FROM transactions WHERE user_id = ?");
$stmt->execute([$user_id]);
$transaction_count = (int)$stmt->fetch()['total'];

// امتیاز کاربر
$points = (int)($user['total_points'] ?? 0);

// تراکنش‌های اخیر (۱۰ تای آخر)
$stmt = $db->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$recent_transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// تعداد درخواست‌های فروش
$stmt = $db->prepare("SELECT COUNT(*) as total FROM register_sell WHERE users_id = ?");
$stmt->execute([$user_id]);
$sell_requests_count = (int)$stmt->fetch()['total'];

// تعداد اعلان‌های نخوانده (فرضی - می‌تونی بعداً جدول notifications بسازی)
$unread_notifications = 0;

// سطح کاربر
$user_levels = [
    'bronze'  => '🥉 برنزی',
    'silver'  => '🥈 نقره‌ای',
    'gold'    => '🥇 طلایی',
    'diamond' => '💎 الماسی',
    'vip'     => '👑 VIP'
];
$user_level_label = $user_levels[$user['user_level'] ?? 'bronze'] ?? '🥉 برنزی';

// آمار این ماه (۳۰ روز اخیر)
$stmt = $db->prepare("
    SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as volume 
    FROM transactions 
    WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
");
$stmt->execute([$user_id]);
$this_month = $stmt->fetch();
$this_month_count = (int)$this_month['count'];
$this_month_volume = (int)$this_month['volume'];

// درصد تغییر نسبت به ماه قبل
$stmt = $db->prepare("
    SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as volume 
    FROM transactions 
    WHERE user_id = ? 
    AND created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) 
    AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
");
$stmt->execute([$user_id]);
$last_month = $stmt->fetch();
$last_month_count = (int)$last_month['count'];
$last_month_volume = (int)$last_month['volume'];

// محاسبه درصد تغییر
if ($last_month_volume > 0) {
    $balance_change = round((($this_month_volume - $last_month_volume) / $last_month_volume) * 100);
} else {
    $balance_change = $this_month_volume > 0 ? 100 : 0;
}

if ($last_month_count > 0) {
    $tx_change = round((($this_month_count - $last_month_count) / $last_month_count) * 100);
} else {
    $tx_change = $this_month_count > 0 ? 100 : 0;
}

// ترجمه نوع تراکنش
$type_labels = [
    'deposit'  => '💰 شارژ',
    'withdraw' => '🏧 برداشت',
    'purchase' => '🛒 خرید',
    'sale'     => '♻️ فروش',
    'reward'   => '🎁 پاداش',
    'fee'      => '📋 کارمزد'
];

// ترجمه وضعیت
$status_labels = [
    'success'  => 'موفق',
    'pending'  => 'در انتظار',
    'failed'   => 'ناموفق',
    'cancelled' => 'لغو شده'
];

$page = "dashboard";
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد | بازیافت نوین</title>
    </head>
<body>

<!-- ==========================================
     داشبورد اصلی
     ========================================== -->
<div class="dashboard-wrapper">

    <!-- ====== هدر ====== -->
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

    <!-- ====== بدنه ====== -->
    <div class="dashboard-body">

        <!-- ====== سایدبار ====== -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <div class="sidebar-avatar"><?= htmlspecialchars($user_initials) ?></div>
                <div class="sidebar-username"><?= htmlspecialchars($user_name) ?></div>
                <span class="sidebar-role"><?= $user_level_label ?></span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard" class="active">
                    <span class="icon">📊</span> داشبورد
                </a></li>
                <li><a href="profile">
                    <span class="icon">👤</span> پروفایل من
                </a></li>
                <li><a href="transactions">
                    <span class="icon">💳</span> تراکنش‌ها
                </a></li>
                <li><a href="request">
                    <span class="icon">📝</span> درخواست‌ها
                </a></li>
                <li><a href="wallet">
                    <span class="icon">💰</span> کیف پول
                </a></li>
                <li><a href="rewards">
                    <span class="icon">⭐</span> امتیازات
                </a></li>
                <li><a href="addresses">
                    <span class="icon">📍</span> آدرس‌ها
                </a></li>
                <li><a href="notifications">
                    <span class="icon">🔔</span> اعلان‌ها
                    <?php if ($unread_notifications > 0): ?>
                        <span class="badge"><?= $unread_notifications ?></span>
                    <?php endif; ?>
                </a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings.php">
                    <span class="icon">⚙️</span> تنظیمات
                </a></li>
                <li><a href="logout" style="color: var(--danger);">
                    <span class="icon">🚪</span> خروج
                </a></li>
                <li><a href="/baziaft234/" style="color: var(--primary);">
                    <span class="icon">🏠</span> بازگشت به خانه
                </a></li>
            </ul>
        </aside>

        <!-- ====== محتوای اصلی ====== -->
        <main class="main-content">

            <!-- هدر صفحه -->
            <div class="page-header">
                <h1>📊 داشبورد</h1>
                <p>به داشبورد خود خوش آمدید، <?= htmlspecialchars($user_name) ?> 👋</p>
            </div>

            <!-- کارت‌های آمار -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-label">موجودی کیف پول</div>
                    <div class="stat-value"><?= number_format($wallet_balance) ?> تومان</div>
                    <?php if ($balance_change != 0): ?>
                        <span class="stat-change <?= $balance_change >= 0 ? 'positive' : 'negative' ?>">
                            <?= $balance_change >= 0 ? '+' : '' ?><?= $balance_change ?>٪ نسبت به ماه قبل
                        </span>
                    <?php else: ?>
                        <span class="stat-change positive">بدون تغییر</span>
                    <?php endif; ?>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🔄</div>
                    <div class="stat-label">تعداد تراکنش‌ها</div>
                    <div class="stat-value"><?= number_format($transaction_count) ?></div>
                    <?php if ($tx_change != 0): ?>
                        <span class="stat-change <?= $tx_change >= 0 ? 'positive' : 'negative' ?>">
                            <?= $tx_change >= 0 ? '+' : '' ?><?= $tx_change ?>٪ نسبت به ماه قبل
                        </span>
                    <?php else: ?>
                        <span class="stat-change positive">بدون تغییر</span>
                    <?php endif; ?>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-label">امتیاز</div>
                    <div class="stat-value"><?= number_format($points) ?></div>
                    <span class="stat-change positive"><?= $user_level_label ?></span>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-label">درخواست‌های فروش</div>
                    <div class="stat-value"><?= number_format($sell_requests_count) ?></div>
                    <span class="stat-change positive">درخواست ثبت‌شده</span>
                </div>
            </div>

            <!-- جدول فعالیت‌های اخیر -->
            <div class="card">
                <div class="card-header">
                    <h3>📋 تراکنش‌های اخیر</h3>
                    <a href="transactions.php" class="card-action">مشاهده همه →</a>
                </div>
                <div class="table-container">
                    <?php if (count($recent_transactions) > 0): ?>
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
                            <?php foreach ($recent_transactions as $tx): ?>
                            <tr>
                                <td>#<?= $tx['id'] ?></td>
                                <td><?= $type_labels[$tx['type']] ?? $tx['type'] ?></td>
                                <td><?= number_format($tx['amount']) ?></td>
                                <td><?= htmlspecialchars($tx['description'] ?? '—') ?></td>
                                <td><?= date('Y/m/d', strtotime($tx['created_at'])) ?></td>
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
                        <p>از <a href="wallet.php">کیف پول</a> شروع کنید!</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- دکمه‌های سریع -->
            <div class="card">
                <div class="card-header">
                    <h3>⚡ اقدامات سریع</h3>
                </div>
                <div class="quick-actions">
                    <a href="transactions.php" class="quick-btn">
                        <span class="qb-icon">💳</span>
                        تراکنش جدید
                    </a>
                    <a href="request" class="quick-btn">
                        <span class="qb-icon">📝</span>
                        درخواست فروش
                    </a>
                    <a href="wallet.php" class="quick-btn">
                        <span class="qb-icon">💰</span>
                        شارژ کیف پول
                    </a>
                    <a href="settings.php" class="quick-btn">
                        <span class="qb-icon">⚙️</span>
                        تنظیمات حساب
                    </a>
                </div>
            </div>

        </main>

    </div>

</div>

<!-- ==========================================
     اسکریپت‌های جاوااسکریپت
     ========================================== -->
<script>
// حذف رفرنس‌های شکسته به المان‌هایی که وجود ندارن
// فقط اگر المان وجود داشت، event listener بنداز

const toggleBtn = document.getElementById('sidebarToggle');
const sidebarOverlay = document.getElementById('sidebarOverlay');

// تابع باز/بسته کردن منوی سایدبار هدر
const profileBtn = document.getElementById('sidebarToggleBtn');
const profileSidebar = document.getElementById('profileSidebar');
const overlay = document.getElementById('sidebarOverlay');

function openSidebar() {
    if (profileSidebar) profileSidebar.classList.add('active');
    if (overlay) overlay.classList.add('active');
    if (toggleBtn) toggleBtn.classList.add('active');
}

function closeSidebar() {
    if (profileSidebar) profileSidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
    if (toggleBtn) toggleBtn.classList.remove('active');
}

if (profileBtn) {
    profileBtn.addEventListener('click', function() {
        if (profileSidebar && profileSidebar.classList.contains('active')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });
}

if (overlay) {
    overlay.addEventListener('click', closeSidebar);
}

if (toggleBtn) {
    toggleBtn.addEventListener('click', function() {
        if (profileSidebar && profileSidebar.classList.contains('active')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });
}
</script>

</body>
</html>