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

// اعلان‌های نمونه (سیستم اعلان‌ها از جدول transactions و register_sell)
$notifications = [];

// تراکنش‌های اخیر به عنوان اعلان
$stmt = $db->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 15");
$stmt->execute([$user_id]);
$txs = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($txs as $tx) {
    $emoji = ['deposit' => '💰', 'withdraw' => '🏧', 'purchase' => '🛒', 'sale' => '♻️', 'reward' => '🎁', 'fee' => '📋'][$tx['type']] ?? '📌';
    $notifications[] = [
        'emoji' => $emoji,
        'title' => $emoji . ' تراکنش ' . ($tx['status'] === 'success' ? 'موفق' : ($tx['status'] === 'pending' ? 'در انتظار' : 'ناموفق')),
        'message' => ($tx['description'] ?? 'تراکنش') . ' - ' . number_format($tx['amount']) . ' تومان',
        'time' => $tx['created_at'],
        'type' => $tx['status']
    ];
}

// درخواست‌های فروش اخیر
$stmt = $db->prepare("SELECT rs.*, r.recyclingtype FROM register_sell rs JOIN recycling r ON rs.recyclingtype_id = r.id WHERE rs.users_id = ? ORDER BY rs.id DESC LIMIT 10");
$stmt->execute([$user_id]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($requests as $req) {
    $notifications[] = [
        'emoji' => '📝',
        'title' => '📝 درخواست فروش ثبت شد',
        'message' => $req['recyclingtype'] . ' - ' . number_format($req['weight']) . ' کیلوگرم',
        'time' => '2026-07-' . rand(1, 10) . ' 0' . rand(8, 9) . ':00:00',
        'type' => 'info'
    ];
}

// اعلان‌های سیستمی
$system_notifications = [
    ['emoji' => '🎉', 'title' => '🎉 به بازیافت نوین خوش آمدید!', 'message' => 'از اینکه به جمع ما پیوستید خوشحالیم. با ثبت اولین درخواست فروش ۵۰ امتیاز بگیرید.', 'time' => $user['created_at'], 'type' => 'info'],
    ['emoji' => '⭐', 'title' => '⭐ فرصت ارتقا سطح', 'message' => 'تنها ' . (500 - (int)($user['total_points'] ?? 0)) . ' امتیاز تا سطح نقره‌ای فاصله دارید. بیشتر فعالیت کنید!', 'time' => date('Y-m-d H:i:s'), 'type' => 'info'],
    ['emoji' => '💰', 'title' => '💰 شارژ ویژه', 'message' => 'این هفته شارژ کیف پول با ۱۰٪ امتیاز بیشتر همراه است.', 'time' => date('Y-m-d H:i:s', strtotime('-1 day')), 'type' => 'promo'],
];

$all_notifications = array_merge($notifications, $system_notifications);

// مرتب‌سازی بر اساس زمان
usort($all_notifications, function($a, $b) {
    return strtotime($b['time']) - strtotime($a['time']);
});

$type_styles = [
    'success' => ['bg' => 'var(--success-bg)', 'border' => '#22c55e', 'color' => '#4ade80'],
    'pending' => ['bg' => 'var(--warning-bg)', 'border' => '#eab308', 'color' => '#fbbf24'],
    'failed'  => ['bg' => 'var(--danger-bg)', 'border' => '#ef4444', 'color' => '#f87171'],
    'info'    => ['bg' => 'rgba(99,102,241,0.1)', 'border' => '#6366f1', 'color' => '#818cf8'],
    'promo'   => ['bg' => 'rgba(245,158,11,0.1)', 'border' => '#f59e0b', 'color' => '#fbbf24'],
];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعلان‌ها | بازیافت نوین</title>
    <style>
        .notif-card {
            display: flex;
            gap: 16px;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 8px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }
        .notif-card:hover { border-color: var(--primary); }
        .notif-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .notif-time {
            font-size: 0.75rem;
            color: var(--text-muted);
            flex-shrink: 0;
            white-space: nowrap;
        }
    </style>
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
                <li><a href="notifications" class="active"><span class="icon">🔔</span> اعلان‌ها <span class="badge"><?= count($all_notifications) ?></span></a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings"><span class="icon">⚙️</span> تنظیمات</a></li>
                <li><a href="logout" style="color: var(--danger);"><span class="icon">🚪</span> خروج</a></li>
                <li><a href="index" style="color: var(--primary);"><span class="icon">🏠</span> خانه</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>🔔 اعلان‌ها</h1>
                <p><?= count($all_notifications) ?> اعلان</p>
            </div>

            <div class="card">
                <?php if (count($all_notifications) > 0): ?>
                    <?php foreach ($all_notifications as $notif): 
                        $style = $type_styles[$notif['type']] ?? $type_styles['info'];
                    ?>
                    <div class="notif-card" style="background: <?= $style['bg'] ?>; border-right: 3px solid <?= $style['border'] ?>;">
                        <div class="notif-icon" style="background: <?= $style['bg'] ?>;">
                            <?= $notif['emoji'] ?>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <strong style="color: <?= $style['color'] ?>;"><?= htmlspecialchars($notif['title']) ?></strong>
                            <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 4px 0 0 0;"><?= htmlspecialchars($notif['message']) ?></p>
                        </div>
                        <div class="notif-time"><?= date('Y/m/d H:i', strtotime($notif['time'])) ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div style="text-align: center; padding: 40px;">
                    <p style="font-size: 2rem;">🔕</p>
                    <p style="color: var(--text-secondary);">هنوز هیچ اعلانی ندارید.</p>
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