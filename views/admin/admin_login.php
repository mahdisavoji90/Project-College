<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once __DIR__ . "/inc_db.php";
// فایل اتصال به دیتابیس

$error = '';

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {

        $error = "نام کاربری و رمز عبور الزامی است";

    } else {

        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['password']) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            redirect(url('/admin'));
            exit;

        } else {

            $error = "نام کاربری یا رمز عبور اشتباه است";

        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود ادمین</title>
    <style>
    
* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
}

body { 
    font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.15) 0%, transparent 70%);
    top: -250px;
    right: -250px;
    border-radius: 50%;
}

body::after {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(118, 75, 162, 0.15) 0%, transparent 70%);
    bottom: -200px;
    left: -200px;
    border-radius: 50%;
}

.login-box { 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    backdrop-filter: blur(10px);
    padding: 50px 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    width: 100%;
    max-width: 420px;
    animation: fadeIn 0.5s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    z-index: 1;
}

.login-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px 20px 0 0;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 { 
    text-align: center;
    margin-bottom: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 28px;
    font-weight: 600;
}

.form-group { 
    margin-bottom: 24px;
    position: relative;
}

label { 
    display: block;
    margin-bottom: 10px;
    color: #94a3b8;
    font-weight: 500;
    font-size: 14px;
}

input[type="text"], 
input[type="password"] { 
    width: 100%;
    padding: 14px 16px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: rgba(15, 23, 42, 0.5);
    color: #e2e8f0;
}

input[type="text"]::placeholder,
input[type="password"]::placeholder {
    color: #64748b;
}

input[type="text"]:focus, 
input[type="password"]:focus { 
    outline: none;
    border-color: #667eea;
    background: rgba(15, 23, 42, 0.8);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

button { 
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-top: 10px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

button:hover { 
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}

button:active {
    transform: translateY(0);
}

.error { 
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #fca5a5;
    padding: 14px;
    border-radius: 10px;
    margin-bottom: 24px;
    text-align: center;
    border-left: 4px solid #ef4444;
    font-size: 14px;
    animation: shake 0.5s ease;
    backdrop-filter: blur(10px);
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}

@media (max-width: 480px) {
    .login-box {
        padding: 40px 30px;
    }
    
    h2 {
        font-size: 24px;
    }
}

</style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 ورود به پنل ادمین</h2>
        <?php if($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>نام کاربری</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>رمز عبور</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">ورود</button>
        </form>
    </div>
</body>
</html>
