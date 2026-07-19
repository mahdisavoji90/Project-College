<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
// ============================================
// شروع سشن
// ============================================
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
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect(url('/logout'));
    exit;
}

$user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) {
    $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);
}

// ============================================
// دریافت جزئیات درخواست
// ============================================
$request_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($request_id < 1) {
    redirect(url('/requests'));
    exit;
}

$stmt = $db->prepare("
    SELECT 
        r.*,
        rec.name as recycling_name,
        rec.price_per_kg,
        rec.image as recycling_image,
        rec.description as recycling_description
    FROM register_sell r 
    LEFT JOIN recycling rec ON r.recyclingtype_id = rec.id 
    WHERE r.id = ? AND r.users_id = ?
");
$stmt->execute([$request_id, $user_id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    redirect(url('/requests'));
    exit;
}

// محاسبه قیمت تخمینی
$estimated_price = ($request['weight'] ?? 0) * ($request['price_per_kg'] ?? 0);

$page = "requests";
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات درخواست - بازیافت نوین</title>
    <link rel="stylesheet" href="<?= url('views/style.php') ?>">
</head>
<body>

<div class="dashboard-wrapper">

    <!-- ========== هدر ========== -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <div class="logo-icon">♻️</div>
                <span class="logo-text">بازیافت نوین</span>
            </div>
            <div class="header-right">
                <span class="date"><?= date('Y/m/d') ?></span>
                <div class="user-profile-btn">
                    <span class="user-name"><?= $user_name ?></span>
                    <div class="user-avatar"><?= $user_initials ?></div>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== بدنه ========== -->
    <div class="dashboard-body">

        <!-- ====== سایدبار ====== -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <div class="sidebar-avatar"><?= $user_initials ?></div>
                <div class="sidebar-username"><?= $user_name ?></div>
                <span class="sidebar-role">کاربر ویژه</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard"><span class="icon">📊</span> داشبورد</a></li>
                <li><a href="profile"><span class="icon">👤</span> پروفایل من</a></li>
                <li><a href="transactions"><span class="icon">💳</span> تراکنش‌ها</a></li>
                <li><a href="requests" class="active"><span class="icon">📝</span> درخواست‌های فروش</a></li>
                <li><a href="wallet"><span class="icon">💰</span> کیف پول</a></li>
                <li><a href="rewards"><span class="icon">⭐</span> امتیازات</a></li>
                <li><a href="settings"><span class="icon">⚙️</span> تنظیمات</a></li>
                <div class="sidebar-divider"></div>
                <li><a href="logout" style="color: var(--danger);"><span class="icon">🚪</span> خروج</a></li>
            </ul>
        </aside>

        <!-- ====== محتوای اصلی ====== -->
        <main class="main-content">

            <!-- هدر صفحه -->
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h1>📋 جزئیات درخواست</h1>
                    <p>کد پیگیری: <strong style="color: var(--primary-light);"><?= htmlspecialchars($request['tracking_code'] ?? '---') ?></strong></p>
                </div>
                <a href="<?= url('requests') ?>" class="btn btn-outline" style="text-decoration: none;">⬅️ بازگشت به لیست</a>
            </div>

            <!-- ====== کارت اطلاعات ====== -->
            <div class="card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <h4 style="color: var(--text-secondary); margin-bottom: 12px;">📋 اطلاعات درخواست</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div><strong>نوع ضایعات:</strong> <?= htmlspecialchars($request['recycling_name'] ?? 'نامشخص') ?></div>
                            <div><strong>وزن:</strong> <?= number_format($request['weight']) ?> کیلوگرم</div>
                            <div><strong>قیمت هر کیلو:</strong> <?= number_format($request['price_per_kg'] ?? 0) ?> تومان</div>
                            <div><strong>قیمت تخمینی:</strong> <strong style="color: var(--success);"><?= number_format($estimated_price) ?> تومان</strong></div>
                            <div><strong>وضعیت:</strong> 
                                <?php 
                                $status_labels = [
                                    'pending' => 'در انتظار بررسی',
                                    'in_progress' => 'در حال انجام',
                                    'completed' => 'تکمیل شده',
                                    'cancelled' => 'لغو شده',
                                    'rejected' => 'رد شده'
                                ];
                                ?>
                                <span class="status <?= htmlspecialchars($request['status']) ?>">
                                    <?= $status_labels[$request['status']] ?? $request['status'] ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 style="color: var(--text-secondary); margin-bottom: 12px;">📞 اطلاعات تماس</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div><strong>شماره تماس:</strong> <?= htmlspecialchars($request['numberphone'] ?? 'ثبت نشده') ?></div>
                            <div><strong>تاریخ ثبت:</strong> <?= date('Y/m/d H:i', strtotime($request['created_at'])) ?></div>
                            <?php if ($request['updated_at'] && $request['updated_at'] != $request['created_at']): ?>
                                <div><strong>آخرین بروزرسانی:</strong> <?= date('Y/m/d H:i', strtotime($request['updated_at'])) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr style="border-color: var(--border-color); margin: 20px 0;">

                <div>
                    <h4 style="color: var(--text-secondary); margin-bottom: 12px;">📝 توضیحات</h4>
                    <div style="background: var(--bg-dark); padding: 16px; border-radius: 12px; border: 1px solid var(--border-color);">
                        <?= nl2br(htmlspecialchars($request['description'] ?? 'توضیحی ثبت نشده')) ?>
                    </div>
                </div>

                <?php if (!empty($request['recycling_image'])): ?>
                    <div style="margin-top: 20px;">
                        <h4 style="color: var(--text-secondary); margin-bottom: 12px;">🖼️ تصویر ضایعات</h4>
                        <img src="<?= htmlspecialchars($request['recycling_image']) ?>" style="max-width: 300px; border-radius: 12px; border: 1px solid var(--border-color);">
                    </div>
                <?php endif; ?>

                <?php if (!empty($request['recycling_description'])): ?>
                    <div style="margin-top: 20px;">
                        <h4 style="color: var(--text-secondary); margin-bottom: 12px;">ℹ️ توضیحات نوع ضایعات</h4>
                        <div style="background: var(--bg-dark); padding: 16px; border-radius: 12px; border: 1px solid var(--border-color); color: var(--text-secondary);">
                            <?= nl2br(htmlspecialchars($request['recycling_description'])) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="<?= url('requests') ?>" class="btn btn-outline" style="text-decoration: none;">⬅️ بازگشت</a>
                    <?php if (in_array($request['status'], ['pending', 'in_progress'])): ?>
                        <a href="?cancel=<?= $request['id'] ?>" class="btn btn-outline" style="text-decoration: none; color: var(--danger); border-color: var(--danger);" onclick="return confirm('آیا از لغو این درخواست مطمئن هستید؟')">❌ لغو درخواست</a>
                    <?php endif; ?>
                </div>
            </div>

        </main>

    </div>

</div>

</body>
</html>