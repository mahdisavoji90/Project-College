<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
// اگر قبلاً لاگین کرده بود، بفرست به داشبورد
if (isset($_SESSION['user_id'])) {
    redirect(url('/dashboard'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'لطفاً ایمیل و رمز عبور را وارد کنید.';
    } else {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            redirect(url('/dashboard'));
            exit;
        } else {
            $error = 'ایمیل یا رمز عبور اشتباه است.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود | بازیافت نوین</title>
    <?php require_once(BASE_PATH . "/views/style.php"); ?>
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-dark);
            padding: 20px;
        }
        .login-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: var(--shadow);
        }
        .login-card h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        .login-card p {
            text-align: center;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }
    </style>
</head>
<body>

<div class="login-page">
    <div class="login-card">
        <h1>♻️ ورود</h1>
        <p>به بازیافت نوین خوش آمدید</p>

        <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group" style="margin-bottom: 16px;">
                <label>ایمیل</label>
                <input type="email" name="email" placeholder="example@mail.com" required
                       style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px; color: var(--text-primary); width: 100%; font-size: 0.95rem;">
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label>رمز عبور</label>
                <input type="password" name="password" placeholder="••••••" required
                       style="background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px; color: var(--text-primary); width: 100%; font-size: 0.95rem;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                🚀 ورود به حساب
            </button>
        </form>

        <p style="text-align: center; margin-top: 24px; color: var(--text-muted);">
            حساب ندارید؟ <a href="index.php" style="color: var(--primary-light);">ثبت‌نام کنید</a>
        </p>
    </div>
</div>

</body>
</html>