<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";

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

$user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$user_initials = mb_substr($user['first_name'] ?? '', 0, 1) . mb_substr($user['last_name'] ?? '', 0, 1);
if (empty(trim($user_initials))) {
    $user_initials = mb_substr($user['email'] ?? 'م', 0, 1);
}

// ============================================
// دریافت لیست انواع بازیافت
// ============================================
$recycling_types = [];
$stmt = $db->query("SELECT * FROM recycling ORDER BY name");
$recycling_types = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================================
// دریافت لیست درخواست‌ها
// ============================================
$page_num = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page_num - 1) * $per_page;

$status_filter = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';

$where_conditions = ["r.users_id = ?"];
$params = [$user_id];

if ($status_filter !== 'all') {
    $where_conditions[] = "r.status = ?";
    $params[] = $status_filter;
}

if (!empty($search)) {
    $where_conditions[] = "(r.description LIKE ? OR r.numberphone LIKE ? OR r.tracking_code LIKE ? OR rec.name LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

$where_clause = implode(" AND ", $where_conditions);

// ============================================
// تعداد کل
// ============================================
$count_stmt = $db->prepare("
    SELECT COUNT(*) FROM register_sell r 
    LEFT JOIN recycling rec ON r.recyclingtype_id = rec.id 
    WHERE $where_clause
");
$count_stmt->execute($params);
$total_requests = $count_stmt->fetchColumn();
$total_pages = ceil($total_requests / $per_page);

// ============================================
// دریافت درخواست‌ها
// ============================================
$stmt = $db->prepare("
    SELECT 
        r.*,
        rec.name as recycling_name,
        rec.price_per_kg,
        rec.image as recycling_image
    FROM register_sell r 
    LEFT JOIN recycling rec ON r.recyclingtype_id = rec.id 
    WHERE $where_clause 
    ORDER BY r.created_at DESC 
    LIMIT ? OFFSET ?
");

// پارامترها رو به صورت جداگانه bind کنید
$param_index = 1;
foreach ($params as $param) {
    $stmt->bindValue($param_index, $param);
    $param_index++;
}

// LIMIT و OFFSET رو با PDO::PARAM_INT bind کنید
$stmt->bindValue($param_index, $per_page, PDO::PARAM_INT);
$param_index++;
$stmt->bindValue($param_index, $offset, PDO::PARAM_INT);

$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================================
// پردازش درخواست جدید
// ============================================
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_request') {
    $recyclingtype_id = (int)$_POST['recyclingtype_id'];
    $weight = (int)$_POST['weight'];
    $description = trim($_POST['description'] ?? '');
    $numberphone = trim($_POST['numberphone'] ?? '');
    
    if (empty($recyclingtype_id) || $recyclingtype_id < 1) {
        $error_message = 'لطفاً نوع بازیافت را انتخاب کنید';
    } elseif ($weight < 1) {
        $error_message = 'وزن باید بیشتر از 0 باشد';
    } elseif (empty($description)) {
        $error_message = 'توضیحات الزامی است';
    } elseif (!empty($numberphone) && !preg_match('/^09[0-9]{9}$/', $numberphone)) {
        $error_message = 'شماره تماس نامعتبر است';
    } else {
        $tracking_code = 'REQ-' . strtoupper(uniqid()) . '-' . date('Ymd');
        
        $stmt = $db->prepare("
            INSERT INTO register_sell 
            (recyclingtype_id, weight, description, numberphone, users_id, status, tracking_code, created_at)
            VALUES (?, ?, ?, ?, ?, 'pending', ?, NOW())
        ");
        
        if ($stmt->execute([$recyclingtype_id, $weight, $description, $numberphone, $user_id, $tracking_code])) {
            $success_message = '✅ درخواست فروش با موفقیت ثبت شد! کد پیگیری: ' . $tracking_code;
            echo "<meta http-equiv='refresh' content='2'>";
        } else {
            $error_message = '❌ خطا در ثبت درخواست';
        }
    }
}

// ============================================
// پردازش لغو درخواست
// ============================================
if (isset($_GET['cancel']) && is_numeric($_GET['cancel'])) {
    $request_id = (int)$_GET['cancel'];
    $stmt = $db->prepare("
        UPDATE register_sell 
        SET status = 'cancelled', updated_at = NOW() 
        WHERE id = ? AND users_id = ? AND status IN ('pending', 'in_progress')
    ");
    if ($stmt->execute([$request_id, $user_id])) {
        $success_message = '✅ درخواست با موفقیت لغو شد';
        redirect(url('/requests?success=1'));
        exit;
    }
}

// بررسی پیام موفقیت از redirect
if (isset($_GET['success'])) {
    $success_message = '✅ درخواست با موفقیت لغو شد';
}

$page = "requests";
?>
<?php require_once(BASE_PATH . "/views/style.php"); ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درخواست‌های فروش | بازیافت نوین</title>
    </head>
<body>

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
                <span class="sidebar-role"><?= htmlspecialchars($user['user_level'] ?? 'bronze') ?></span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?= url('dashboard') ?>">
                    <span class="icon">📊</span> داشبورد
                </a></li>
                <li><a href="<?= url('profile') ?>">
                    <span class="icon">👤</span> پروفایل من
                </a></li>
                <li><a href="<?= url('requests') ?>" class="active">
                    <span class="icon">📝</span> درخواست‌ها
                </a></li>
                <li><a href="<?= url('transactions') ?>">
                    <span class="icon">💳</span> تراکنش‌ها
                </a></li>
                <li><a href="<?= url('wallet') ?>">
                    <span class="icon">💰</span> کیف پول
                </a></li>
                <li><a href="<?= url('rewards') ?>">
                    <span class="icon">⭐</span> امتیازات
                </a></li>
                <li><a href="<?= url('addresses') ?>">
                    <span class="icon">📍</span> آدرس‌ها
                </a></li>
                <li><a href="<?= url('notifications') ?>">
                    <span class="icon">🔔</span> اعلان‌ها
                </a></li>
                <div class="sidebar-divider"></div>
                <li><a href="<?= url('settings') ?>">
                    <span class="icon">⚙️</span> تنظیمات
                </a></li>
                <li><a href="<?= url('logout') ?>" style="color: var(--danger);">
                    <span class="icon">🚪</span> خروج
                </a></li>
            </ul>
        </aside>

        <!-- ====== محتوای اصلی ====== -->
        <main class="main-content">

            <!-- هدر صفحه -->
            <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>📋 درخواست‌های فروش</h1>
                    <p>مدیریت درخواست‌های ثبت‌شده برای فروش ضایعات</p>
                </div>
                <button class="btn btn-primary" id="showNewRequestBtn" style="padding: 12px 24px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 0.95rem;">
                    ➕ درخواست جدید
                </button>
            </div>

            <!-- پیام‌ها -->
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?= $success_message ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?= $error_message ?></div>
            <?php endif; ?>

            <!-- ====== فرم درخواست جدید ====== -->
            <div class="card" id="newRequestForm" style="display: none;">
                <div class="card-header">
                    <h3>✏️ ثبت درخواست فروش جدید</h3>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="new_request">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>نوع بازیافت <span class="required">*</span></label>
                            <select name="recyclingtype_id" required>
                                <option value="">-- انتخاب کنید --</option>
                                <?php foreach ($recycling_types as $type): ?>
                                    <option value="<?= $type['id'] ?>" data-price="<?= $type['price_per_kg'] ?>">
                                        <?= htmlspecialchars($type['name']) ?> - <?= number_format($type['price_per_kg']) ?> تومان/کیلو
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>وزن (کیلوگرم) <span class="required">*</span></label>
                            <input type="number" name="weight" min="1" step="1" required placeholder="مثلاً ۵">
                        </div>
                        
                        <div class="form-group full-width">
                            <label>شماره تماس</label>
                            <input type="text" name="numberphone" placeholder="مثلاً 09123456789" dir="ltr">
                            <small>در صورت نیاز به هماهنگی، شماره تماس خود را وارد کنید</small>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>توضیحات <span class="required">*</span></label>
                            <textarea name="description" rows="4" required placeholder="توضیحات مربوط به ضایعات خود را وارد کنید..."></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 32px; background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 600;">
                            ✅ ثبت درخواست
                        </button>
                        <button type="button" class="btn btn-secondary" id="cancelNewRequestBtn" style="padding: 12px 32px; background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); border-radius: 12px; cursor: pointer; font-weight: 600;">
                            ❌ انصراف
                        </button>
                    </div>
                </form>
            </div>

            <!-- ====== فیلترها ====== -->
            <div class="card">
                <div class="card-header">
                    <h3>🔍 فیلتر درخواست‌ها</h3>
                </div>
                <form method="GET" action="">
                    <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: end;">
                        <div class="form-group" style="flex: 1; min-width: 150px;">
                            <label>وضعیت</label>
                            <select name="status" onchange="this.form.submit()" style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px; color: var(--text-primary); font-size: 0.95rem; width: 100%;">
                                <option value="all" <?= $status_filter === 'all' ? 'selected' : '' ?>>همه</option>
                                <option value="pending" <?= $status_filter === 'pending' ? 'selected' : '' ?>>در انتظار بررسی</option>
                                <option value="in_progress" <?= $status_filter === 'in_progress' ? 'selected' : '' ?>>در حال انجام</option>
                                <option value="completed" <?= $status_filter === 'completed' ? 'selected' : '' ?>>تکمیل شده</option>
                                <option value="cancelled" <?= $status_filter === 'cancelled' ? 'selected' : '' ?>>لغو شده</option>
                                <option value="rejected" <?= $status_filter === 'rejected' ? 'selected' : '' ?>>رد شده</option>
                            </select>
                        </div>
                        <div class="form-group" style="flex: 2; min-width: 200px;">
                            <label>جستجو</label>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="جستجو در توضیحات، کد پیگیری..." style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px; color: var(--text-primary); font-size: 0.95rem; width: 100%;">
                        </div>
                        <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; height: fit-content;">
                            🔍 جستجو
                        </button>
                        <?php if ($status_filter !== 'all' || !empty($search)): ?>
                            <a href="<?= url('requests') ?>" style="padding: 12px 24px; background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); border-radius: 12px; cursor: pointer; font-weight: 600; text-decoration: none; height: fit-content;">
                                ✕ حذف فیلتر
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- ====== جدول درخواست‌ها ====== -->
            <div class="card">
                <div class="card-header">
                    <h3>📋 لیست درخواست‌ها</h3>
                    <span style="color: var(--text-secondary); font-size: 0.85rem;">تعداد: <?= number_format($total_requests) ?></span>
                </div>
                <div class="table-container">
                    <?php if (count($requests) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>کد پیگیری</th>
                                <th>نوع بازیافت</th>
                                <th>وزن (کیلو)</th>
                                <th>مبلغ تخمینی</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $req): 
                                $estimated_price = (int)($req['weight'] ?? 0) * (int)($req['price_per_kg'] ?? 0);
                                $status_labels = [
                                    'pending' => 'در انتظار بررسی',
                                    'in_progress' => 'در حال انجام',
                                    'completed' => 'تکمیل شده',
                                    'cancelled' => 'لغو شده',
                                    'rejected' => 'رد شده'
                                ];
                            ?>
                            <tr>
                                <td>#<?= $req['id'] ?></td>
                                <td style="direction: ltr; font-family: monospace;"><?= htmlspecialchars($req['tracking_code'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($req['recycling_name'] ?? '—') ?></td>
                                <td><?= number_format((int)$req['weight']) ?></td>
                                <td><?= number_format($estimated_price) ?> تومان</td>
                                <td><?= date('Y/m/d', strtotime($req['created_at'])) ?></td>
                                <td>
                                    <span class="status <?= htmlspecialchars($req['status']) ?>">
                                        <?= $status_labels[$req['status']] ?? $req['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (in_array($req['status'], ['pending', 'in_progress'])): ?>
                                        <a href="?cancel=<?= $req['id'] ?>" class="btn" style="color: var(--danger); text-decoration: none;" onclick="return confirm('آیا از لغو این درخواست اطمینان دارید؟')">
                                            ❌ لغو
                                        </a>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <!-- صفحه‌بندی -->
                    <?php if ($total_pages > 1): ?>
                    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                        <?php if ($page_num > 1): ?>
                            <a href="?page=<?= $page_num - 1 ?>&status=<?= $status_filter ?>&search=<?= urlencode($search) ?>" style="padding: 8px 16px; background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none;">← قبلی</a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?= $i ?>&status=<?= $status_filter ?>&search=<?= urlencode($search) ?>" style="padding: 8px 16px; background: <?= $i === $page_num ? 'var(--primary)' : 'var(--bg-card)' ?>; color: <?= $i === $page_num ? 'white' : 'var(--text-primary)' ?>; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; font-weight: <?= $i === $page_num ? '700' : '400' ?>;">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page_num < $total_pages): ?>
                            <a href="?page=<?= $page_num + 1 ?>&status=<?= $status_filter ?>&search=<?= urlencode($search) ?>" style="padding: 8px 16px; background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none;">بعدی →</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php else: ?>
                    <div class="empty-state" style="text-align: center; padding: 40px 20px;">
                        <p style="font-size: 3rem; margin-bottom: 16px;">📭</p>
                        <p style="color: var(--text-secondary); font-size: 1.1rem;">هنوز هیچ درخواستی ثبت نکرده‌اید.</p>
                        <p style="color: var(--text-muted); margin-top: 8px;">با کلیک روی دکمه "درخواست جدید" اولین درخواست خود را ثبت کنید.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </main>

    </div>

</div>

<!-- ====== اسکریپت‌ها ====== -->
<script>
// نمایش/مخفی کردن فرم درخواست جدید
const showBtn = document.getElementById('showNewRequestBtn');
const cancelBtn = document.getElementById('cancelNewRequestBtn');
const form = document.getElementById('newRequestForm');

if (showBtn) {
    showBtn.addEventListener('click', function() {
        if (form) {
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
            if (form.style.display === 'block') {
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
}

if (cancelBtn) {
    cancelBtn.addEventListener('click', function() {
        if (form) {
            form.style.display = 'none';
        }
    });
}

// سایدبار
const toggleBtn = document.getElementById('sidebarToggleBtn');
const sidebarOverlay = document.getElementById('sidebarOverlay');

if (toggleBtn) {
    toggleBtn.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });
}
</script>

</body>
</html>