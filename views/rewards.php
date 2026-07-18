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

$points = (int)($user['total_points'] ?? 0);
$level = $user['user_level'] ?? 'bronze';

$level_config = [
    'bronze'  => ['name' => 'برنزی', 'emoji' => '🥉', 'min' => 0,     'max' => 500,   'color' => '#cd7f32'],
    'silver'  => ['name' => 'نقره‌ای','emoji' => '🥈', 'min' => 501,   'max' => 1500,  'color' => '#c0c0c0'],
    'gold'    => ['name' => 'طلایی',  'emoji' => '🥇', 'min' => 1501,  'max' => 5000,  'color' => '#ffd700'],
    'diamond' => ['name' => 'الماسی',  'emoji' => '💎', 'min' => 5001,  'max' => 15000, 'color' => '#b9f2ff'],
    'vip'     => ['name' => 'VIP',     'emoji' => '👑', 'min' => 15001, 'max' => 999999, 'color' => '#a855f7']
];

$current_level = $level_config[$level] ?? $level_config['bronze'];

// سیستم امتیازدهی
$reward_rules = [
    ['action' => 'ثبت درخواست فروش', 'points' => 50, 'emoji' => '📝', 'desc' => 'به ازای هر درخواست فروش ضایعات'],
    ['action' => 'فروش موفق', 'points' => 100, 'emoji' => '✅', 'desc' => 'به ازای هر فروش تأیید شده'],
    ['action' => 'شارژ کیف پول', 'points' => 20, 'emoji' => '💰', 'desc' => 'به ازای هر بار شارژ کیف پول'],
    ['action' => 'تکمیل پروفایل', 'points' => 200, 'emoji' => '👤', 'desc' => 'تکمیل تمام اطلاعات پروفایل'],
    ['action' => 'دعوت دوستان', 'points' => 300, 'emoji' => '📨', 'desc' => 'به ازای هر کاربر جدید با کد معرف'],
    ['action' => 'فعالیت روزانه', 'points' => 10, 'emoji' => '📊', 'desc' => 'ورود روزانه و بررسی داشبورد'],
];

// محاسبه پیشرفت به سطح بعدی
$next_levels = ['bronze' => 'silver', 'silver' => 'gold', 'gold' => 'diamond', 'diamond' => 'vip', 'vip' => null];
$next_level_key = $next_levels[$level] ?? null;
$progress = 100;
$points_needed = 0;

if ($next_level_key) {
    $next_config = $level_config[$next_level_key];
    $points_needed = $next_config['min'] - $points;
    $range = $current_level['max'] - $current_level['min'];
    $progress = $range > 0 ? min(100, round((($points - $current_level['min']) / $range) * 100)) : 100;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>امتیازات | بازیافت نوین</title>
    <style>
        .level-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1rem;
            background: <?= $current_level['color'] ?>22;
            color: <?= $current_level['color'] ?>;
            border: 1px solid <?= $current_level['color'] ?>44;
        }
        .progress-bar {
            height: 12px;
            background: var(--bg-dark);
            border-radius: 10px;
            overflow: hidden;
            margin: 8px 0;
        }
        .progress-fill {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(135deg, <?= $current_level['color'] ?>, <?= $next_level_key ? ($level_config[$next_level_key]['color'] ?? '#6366f1') : '#6366f1' ?>);
            width: <?= $progress ?>%;
            transition: width 0.5s ease;
        }
        .reward-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: var(--bg-dark);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 8px;
        }
        .reward-points {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
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
                <li><a href="rewards" class="active"><span class="icon">⭐</span> امتیازات</a></li>
                <li><a href="addresses"><span class="icon">📍</span> آدرس‌ها</a></li>
                <li><a href="notifications"><span class="icon">🔔</span> اعلان‌ها</a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings"><span class="icon">⚙️</span> تنظیمات</a></li>
                <li><a href="logout" style="color: var(--danger);"><span class="icon">🚪</span> خروج</a></li>
                <li><a href="index" style="color: var(--primary);"><span class="icon">🏠</span> خانه</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>⭐ امتیازات و جوایز</h1>
                <p>سطح فعلی شما: <span class="level-badge"><?= $current_level['emoji'] ?> <?= $current_level['name'] ?></span></p>
            </div>

            <!-- کارت‌های آمار -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-label">امتیاز فعلی</div>
                    <div class="stat-value"><?= number_format($points) ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-label">سطح</div>
                    <div class="stat-value" style="font-size: 1.3rem;"><?= $current_level['emoji'] ?> <?= $current_level['name'] ?></div>
                </div>
            </div>

            <!-- نوار پیشرفت -->
            <?php if ($next_level_key): ?>
            <div class="card">
                <div class="card-header">
                    <h3>📈 مسیر پیشرفت</h3>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: var(--text-secondary);"><?= $current_level['emoji'] ?> <?= $current_level['name'] ?></span>
                    <span style="color: var(--text-secondary);"><?= $level_config[$next_level_key]['emoji'] ?> <?= $level_config[$next_level_key]['name'] ?></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p style="color: var(--text-muted); margin-top: 8px;">
                    <?php if ($points_needed > 0): ?>
                        <strong><?= number_format($points_needed) ?></strong> امتیاز تا سطح بعدی
                    <?php else: ?>
                        🎉 آماده ارتقا به سطح بعدی!
                    <?php endif; ?>
                </p>
            </div>
            <?php else: ?>
            <div class="card">
                <p>🎉 شما در بالاترین سطح (VIP) هستید!</p>
            </div>
            <?php endif; ?>

            <!-- جدول سطوح -->
            <div class="card">
                <div class="card-header"><h3>🏆 سطوح کاربری</h3></div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr><th>سطح</th><th>حداقل امتیاز</th><th>حداکثر</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($level_config as $key => $cfg): ?>
                            <tr style="<?= $key === $level ? 'background: rgba(99,102,241,0.1);' : '' ?>">
                                <td><?= $cfg['emoji'] ?> <?= $cfg['name'] ?> <?= $key === $level ? '(شما)' : '' ?></td>
                                <td><?= number_format($cfg['min']) ?></td>
                                <td><?= number_format($cfg['max']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- نحوه کسب امتیاز -->
            <div class="card">
                <div class="card-header"><h3>🎁 نحوه کسب امتیاز</h3></div>
                <?php foreach ($reward_rules as $rule): ?>
                <div class="reward-item">
                    <span style="font-size: 1.5rem;"><?= $rule['emoji'] ?></span>
                    <div style="flex: 1;">
                        <strong style="color: var(--text-primary);"><?= $rule['action'] ?></strong>
                        <p style="color: var(--text-muted); font-size: 0.85rem;"><?= $rule['desc'] ?></p>
                    </div>
                    <div class="reward-points">+<?= $rule['points'] ?> امتیاز</div>
                </div>
                <?php endforeach; ?>
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