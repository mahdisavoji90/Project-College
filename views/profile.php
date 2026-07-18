<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
// ============================================
// شروع سشن (باید اولین خط باشد)
// ============================================
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

// ============================================
// دریافت اطلاعات کاربر
// ============================================
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect(url('/logout'));
    exit;
}

// متغیرهای کاربر
$user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) {
    $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);
}

// ============================================
// پردازش فرم
// ============================================
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    // اعتبارسنجی
    if (empty($first_name) || empty($last_name)) {
        $error_message = 'نام و نام خانوادگی الزامی است';
    } elseif (!empty($phone) && !preg_match('/^09[0-9]{9}$/', $phone)) {
        $error_message = 'شماره تماس نامعتبر است (مثال: 09123456789)';
    } else {
        // آپلود عکس پروفایل
        $profile_picture = $user['profile_picture'];
        
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            $file_type = $_FILES['profile_picture']['type'];
            $file_size = $_FILES['profile_picture']['size'];
            
            if (!in_array($file_type, $allowed_types)) {
                $error_message = 'فقط فایل‌های JPG, PNG و WEBP مجاز هستند';
            } elseif ($file_size > 2 * 1024 * 1024) {
                $error_message = 'حجم فایل نباید بیشتر از 2 مگابایت باشد';
            } else {
                $upload_dir = 'uploads/profiles/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                $new_filename = 'user_' . $user_id . '_' . time() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                    if ($profile_picture && file_exists($profile_picture)) {
                        unlink($profile_picture);
                    }
                    $profile_picture = $upload_path;
                } else {
                    $error_message = 'خطا در آپلود فایل';
                }
            }
        }
        
        // بروزرسانی دیتابیس
        if (empty($error_message)) {
            $stmt = $db->prepare("
                UPDATE users 
                SET first_name = ?, last_name = ?, phone = ?, address = ?, profile_picture = ?
                WHERE id = ?
            ");
            
            if ($stmt->execute([$first_name, $last_name, $phone, $address, $profile_picture, $user_id])) {
                $success_message = 'اطلاعات با موفقیت بروزرسانی شد';
                $user['first_name'] = $first_name;
                $user['last_name'] = $last_name;
                $user['phone'] = $phone;
                $user['address'] = $address;
                $user['profile_picture'] = $profile_picture;
                $user_name = htmlspecialchars($first_name . ' ' . $last_name);
                $user_initials = mb_substr($first_name ?? '', 0, 1) . mb_substr($last_name ?? '', 0, 1);
            } else {
                $error_message = 'خطا در بروزرسانی اطلاعات';
            }
        }
    }
}

$page = "profile";
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل من - بازیافت نوین</title>
    <link rel="stylesheet" href="./style.css">
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
                <div class="user-profile-btn" id="sidebarToggleBtn">
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
                <span class="sidebar-role">
                    <?php
                    $levels = [
                        'bronze' => '🥉 برنزی',
                        'silver' => '🥈 نقره‌ای',
                        'gold' => '🥇 طلایی',
                        'diamond' => '💎 الماس',
                        'vip' => '👑 VIP'
                    ];
                    echo $levels[$user['user_level'] ?? 'bronze'];
                    ?>
                </span>
            </div>

            <ul class="sidebar-menu">
                <li><a href="dashboard">
                    <span class="icon">📊</span> داشبورد
                </a></li>
                <li><a href="profile" class="active">
                    <span class="icon">👤</span> پروفایل من
                </a></li>
                <li><a href="transactions">
                    <span class="icon">💳</span> تراکنش‌ها
                </a></li>
                <li><a href="/baziaft234/request">
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
                    <span class="badge">3</span>
                </a></li>
                <div class="sidebar-divider"></div>
                <li><a href="settings.php">
                    <span class="icon">⚙️</span> تنظیمات
                </a></li>
                <li><a href="logout" style="color: var(--danger);">
                    <span class="icon">🚪</span> خروج
                </a></li>
                 <li><a href="index" style="color: var(--danger);">
                    <span class="icon">🚪</span> بازگشت
                </a></li>
                
            </ul>
        </aside>

        <!-- ====== محتوای اصلی ====== -->
        <main class="main-content">

            <!-- هدر صفحه -->
            <div class="page-header">
                <h1>👤 پروفایل من</h1>
                <p>اطلاعات شخصی خود را مدیریت کنید</p>
            </div>

            <!-- پیام‌ها -->
            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    ✅ <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    ❌ <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <!-- ====== کارت پروفایل ====== -->
            <div class="card profile-card">
                
                <!-- بخش عکس پروفایل -->
                <div class="profile-picture-section">
                    <div class="current-picture">
                        <?php if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])): ?>
                            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="عکس پروفایل" id="profilePreview">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_name ?: 'کاربر') ?>&background=6366f1&color=ffffff&size=200" alt="عکس پروفایل" id="profilePreview">
                        <?php endif; ?>
                    </div>
                    <div class="picture-info">
                        <h3>عکس پروفایل</h3>
                        <p>📷 فرمت‌های مجاز: JPG, PNG, WEBP</p>
                        <p>📦 حداکثر حجم: ۲ مگابایت</p>
                        <p class="email-display">📧 <?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>

                <!-- فرم ویرایش اطلاعات -->
                <form method="POST" enctype="multipart/form-data" class="profile-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">نام <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" 
                                   placeholder="نام خود را وارد کنید" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">نام خانوادگی <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" 
                                   placeholder="نام خانوادگی خود را وارد کنید" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">📱 شماره تماس</label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?= htmlspecialchars($user['phone'] ?? '') ?>" 
                                   placeholder="09123456789" pattern="09[0-9]{9}">
                            <small>فرمت: 09123456789</small>
                        </div>

                        <div class="form-group">
                            <label for="email">📧 ایمیل (غیرقابل تغییر)</label>
                            <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">📍 آدرس</label>
                            <textarea id="address" name="address" rows="3" 
                                      placeholder="آدرس کامل خود را وارد کنید"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label for="profile_picture">🖼️ تغییر عکس پروفایل</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="profile_picture" name="profile_picture" 
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <label for="profile_picture" class="file-input-label">
                                    📷 انتخاب عکس جدید
                                </label>
                                <span class="file-name" id="fileName">فایلی انتخاب نشده</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            💾 ذخیره تغییرات
                        </button>
                        <button type="reset" class="btn btn-outline">
                            🔄 بازنشانی
                        </button>
                        <a href="dashboard.php" class="btn btn-outline" style="text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                            ⬅️ بازگشت
                        </a>
                    </div>
                </form>

                <!-- اطلاعات حساب -->
                <div class="account-info">
                    <h3>📊 اطلاعات حساب</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">👤 سطح کاربری:</span>
                            <span class="info-value">
                                <?php
                                $levels = [
                                    'bronze' => '🥉 برنزی',
                                    'silver' => '🥈 نقره‌ای',
                                    'gold' => '🥇 طلایی',
                                    'diamond' => '💎 الماس',
                                    'vip' => '👑 VIP'
                                ];
                                echo $levels[$user['user_level'] ?? 'bronze'];
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">⭐ امتیاز کل:</span>
                            <span class="info-value"><?= number_format($user['total_points'] ?? 0) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">💰 موجودی کیف پول:</span>
                            <span class="info-value"><?= number_format($user['wallet_balance'] ?? 0) ?> تومان</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">📅 تاریخ عضویت:</span>
                            <span class="info-value"><?= date('Y/m/d', strtotime($user['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                </div>

            </div>

        </main>

    </div>

</div>

<!-- ========================================== -->
<!-- اسکریپت‌ها -->
<!-- ========================================== -->
<script>
    // پیش‌نمایش عکس پروفایل
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('fileName');
        const preview = document.getElementById('profilePreview');
        
        if (file) {
            fileName.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'فایلی انتخاب نشده';
        }
    });

    // حذف خودکار پیام‌ها بعد از ۵ ثانیه
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.transition = 'all 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>

</body>
</html>