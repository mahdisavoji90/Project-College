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

$wallet_balance = (int)($user['wallet_balance'] ?? 0);

// پردازش شارژ کیف پول
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'deposit') {
        $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
        
        if ($amount < 1000) {
            $message = 'حداقل مبلغ شارژ ۱,۰۰۰ تومان است.';
            $message_type = 'error';
        } elseif ($amount > 50000000) {
            $message = 'حداکثر مبلغ شارژ ۵۰,۰۰۰,۰۰۰ تومان است.';
            $message_type = 'error';
        } else {
            try {
                $db->beginTransaction();
                
                // آپدیت موجودی
                $stmt = $db->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
                $stmt->execute([$amount, $user_id]);
                
                // ثبت تراکنش
                $stmt = $db->prepare("INSERT INTO transactions (user_id, amount, type, description, status) VALUES (?, ?, 'deposit', 'شارژ کیف پول', 'success')");
                $stmt->execute([$user_id, $amount]);
                
                $db->commit();
                $wallet_balance += $amount;
                $message = "✅ کیف پول با موفقیت " . number_format($amount) . " تومان شارژ شد.";
                $message_type = 'success';
            } catch (Exception $e) {
                $db->rollBack();
                $message = 'خطا در شارژ کیف پول: ' . $e->getMessage();
                $message_type = 'error';
            }
        }
    } elseif ($_POST['action'] === 'withdraw') {
        $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
        
        if ($amount < 1000) {
            $message = 'حداقل مبلغ برداشت ۱,۰۰۰ تومان است.';
            $message_type = 'error';
        } elseif ($amount > $wallet_balance) {
            $message = 'موجودی شما کافی نیست. موجودی فعلی: ' . number_format($wallet_balance) . ' تومان';
            $message_type = 'error';
        } else {
            try {
                $db->beginTransaction();
                
                $stmt = $db->prepare("UPDATE users SET wallet_balance = wallet_balance - ? WHERE id = ? AND wallet_balance >= ?");
                $stmt->execute([$amount, $user_id, $amount]);
                
                $stmt = $db->prepare("INSERT INTO transactions (user_id, amount, type, description, status) VALUES (?, ?, 'withdraw', 'برداشت از کیف پول', 'success')");
                $stmt->execute([$user_id, $amount]);
                
                $db->commit();
                $wallet_balance -= $amount;
                $message = "✅ برداشت " . number_format($amount) . " تومان با موفقیت انجام شد.";
                $message_type = 'success';
            } catch (Exception $e) {
                $db->rollBack();
                $message = 'خطا در برداشت: ' . $e->getMessage();
                $message_type = 'error';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کیف پول | بازیافت نوین</title>
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
                <li><a href="wallet" class="active"><span class="icon">💰</span> کیف پول</a></li>
                <li><a href="rewards"><span class="icon">⭐</span> امتیازات</a></li>
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
                <h1>💰 کیف پول</h1>
                <p>موجودی: <strong><?= number_format($wallet_balance) ?></strong> تومان</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
            <?php endif; ?>

            <!-- کارت موجودی -->
            <div class="stats-grid" style="margin-bottom: 24px;">
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-label">موجودی فعلی</div>
                    <div class="stat-value" style="font-size: 1.5rem;"><?= number_format($wallet_balance) ?> تومان</div>
                </div>
            </div>

            <!-- شارژ -->
            <div class="card">
                <div class="card-header"><h3>💳 شارژ کیف پول</h3></div>
                <form method="POST">
                    <input type="hidden" name="action" value="deposit">
                    <div class="form-group">
                        <label>مبلغ شارژ (تومان)</label>
                        <input type="number" name="amount" min="1000" max="50000000" step="1000" 
                               placeholder="مثلاً: ۱۰۰,۰۰۰" required
                               style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px; color: var(--text-primary); width: 100%; font-size: 1rem;">
                        <small style="color: var(--text-muted);">حداقل ۱,۰۰۰ تومان | حداکثر ۵۰,۰۰۰,۰۰۰ تومان</small>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 12px;">💰 شارژ کیف پول</button>
                </form>
            </div>

            <!-- برداشت -->
            <div class="card">
                <div class="card-header"><h3>🏧 برداشت وجه</h3></div>
                <form method="POST">
                    <input type="hidden" name="action" value="withdraw">
                    <div class="form-group">
                        <label>مبلغ برداشت (تومان)</label>
                        <input type="number" name="amount" min="1000" max="<?= $wallet_balance ?>" step="1000"
                               placeholder="مثلاً: ۵۰,۰۰۰" required
                               style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px; color: var(--text-primary); width: 100%; font-size: 1rem;">
                        <small style="color: var(--text-muted);">موجودی قابل برداشت: <?= number_format($wallet_balance) ?> تومان</small>
                    </div>
                    <button type="submit" class="btn btn-outline" style="margin-top: 12px;">🏧 برداشت وجه</button>
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