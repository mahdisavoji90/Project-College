<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
// بررسی وجود کلید user_id در سشن
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $user = null;
    }
} else {
    $user = null; // کاربر لاگین نیست
}

?>
    <!-- منوی سایدبار پروفایل -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="profile-sidebar" id="profileSidebar">
    <div class="sidebar-header">
        <div class="profile-avatar">
            <?php if ($user['profile_picture'] && file_exists($user['profile_picture'])): ?>
                            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="عکس پروفایل" id="profilePreview">
             <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['first_name'] . ' ' . $user['last_name'] ?: $user['email']) ?>&background=2dd4bf&color=0f172a&size=200" alt="عکس پروفایل" id="profilePreview">
            <?php endif; ?>       
        </div>
        <h3 class="profile-name"><?= htmlspecialchars($_SESSION['user_email'] ?? 'کاربر مهمان') ?></h3>
        <span class="profile-level">🥉 کاربر برنزی</span>
    </div>

    <nav class="sidebar-menu">
        <a href="#" class="menu-item" data-page="profile">
            <i class="fas fa-user"></i>
            <span>پروفایل من</span>
        </a>

        <a class="menu-item" data-page="dashboard">
        <span class="menu-icon">📊</span>
        <span class="menu-text">داشبورد</span>
        </a>

        <a href="transactions" class="transactions">
        <span class="menu-icon">💰</span>
        <span class="menu-text">تراکنش‌ها</span>
        </a>

        <a href="requests" class="requests">
        <span class="menu-icon">📦</span>
        <span class="menu-text">درخواست‌های من</span>
        </a>

        <a href="wallet" class="wallet">
        <span class="menu-icon">💳</span>
        <span class="menu-text">کیف پول</span>
        </a>

        <a href="rewards" class="rewards">
        <span class="menu-icon">🎁</span>
        <span class="menu-text">امتیازات و جوایز</span>
        </a>

        <a href="addresses" class="addresses">
        <span class="menu-icon">📍</span>
        <span class="menu-text">آدرس‌های من</span>
        </a>

        <a href="notifications" class="notifications">
        <span class="menu-icon">🔔</span>
        <span class="menu-text">اعلان‌ها</span>
        <span class="badge">3</span>
        </a>

        <a href="settings" class="settings">
        <span class="menu-icon">⚙️</span>
        <span class="menu-text">تنظیمات</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <button class="btn-logout" id="sidebarLogout">
            <span>🚪</span> خروج از حساب
        </button>
    </div>
</aside>

<!-- دکمه باز کردن منو (اضافه کن به header) -->
<button class="sidebar-toggle" id="sidebarToggle" style="<?= isset($_SESSION['user_id']) ? 'display: flex;' : 'display: none;' ?>">
    <span></span>
    <span></span>
    <span></span>
</button>

    <div class="container header-inner">
        <!-- دکمه ها اول می آیند -->
        <div class="controls-wrapper">
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-welcome" id="userWelcomeArea" style="<?= isset($_SESSION['user_id']) ? 'display: block;' : 'display: none;' ?>">
            <span style="color:#cbd5e6;">خوش آمدید، <?= htmlspecialchars($_SESSION['user_email']) ?></span>                <button class="btn btn-outline" id="logoutBtn" style="border-color:#64748b;">خروج</button>
            </div>
            <?php else: ?>
                <div class="auth-buttons" id="authButtonsArea">
                    <button class="btn btn-outline" id="loginNavBtn">ورود</button>
                    <button class="btn btn-outline" id="registerNavBtn">ثبت‌نام</button>
            </div>
            <?php endif; ?>
        </div>
    <!-- لوگو بعد از آن می آید -->
    <div class="logo">
        <h1>♻️ بازیافت نوین</h1>
        <p>خرید آنلاین ضایعات الکترونیک و فلزات</p>
    </div>
</div>


