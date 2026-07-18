<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/bootstrap.php");
require_once __DIR__ . "/inc_db.php";
require_once __DIR__ . "/inc_db.php";
// بررسی لاگین
if(!isset($_SESSION['admin_id'])){
    redirect(url('/admin/login'));
    exit;
}

// آمار کلی
$total_users = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_requests = $db->query("SELECT COUNT(*) FROM register_sell")->fetchColumn();
$total_types = $db->query("SELECT COUNT(*) FROM recycling")->fetchColumn();

// دریافت داده‌های نمودار برای ۷ روز اخیر
$chartData = $db->query("
    SELECT DATE(created_at) as date, COUNT(*) as count 
    FROM register_sell 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
    GROUP BY DATE(created_at) 
    ORDER BY date ASC
")->fetchAll(PDO::FETCH_KEY_PAIR);

$labels = [];
$data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = $date;
    $data[] = $chartData[$date] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    color: #e2e8f0;
}

.header { 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white; 
    padding: 24px 40px;
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.header h1 { 
    font-size: 28px;
    font-weight: 600;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.logout { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.logout:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.container { 
    max-width: 1200px; 
    margin: 40px auto; 
    padding: 0 30px; 
}

.stats { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
    gap: 24px; 
    margin-bottom: 40px; 
}

.stat-card { 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 35px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
    border-color: rgba(102, 126, 234, 0.3);
}

.stat-card h3 { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 42px;
    margin-bottom: 12px;
    font-weight: 700;
}

.stat-card p { 
    color: #94a3b8;
    font-size: 16px;
    font-weight: 500;
}

.menu { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
    gap: 24px; 
}

.menu-item { 
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.menu-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.menu-item:hover::before {
    opacity: 1;
}

.menu-item:hover { 
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
    border-color: rgba(102, 126, 234, 0.3);
}

.menu-item a { 
    text-decoration: none;
    color: #e2e8f0;
    display: block;
    position: relative;
    z-index: 1;
}

.menu-item h2 { 
    font-size: 56px;
    margin-bottom: 16px;
    filter: drop-shadow(0 4px 8px rgba(102, 126, 234, 0.3));
}

.menu-item p { 
    color: #94a3b8;
    font-size: 18px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .header {
        padding: 20px;
        flex-direction: column;
        gap: 15px;
    }
    
    .header h1 {
        font-size: 24px;
    }
    
    .container {
        padding: 0 20px;
        margin: 30px auto;
    }
    
    .stats, .menu {
        gap: 20px;
    }
}
</style>
</head>
<body>
    <div class="header">
        <h1>پنل مدیریت - خوش آمدید <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>
        <a href="/baziaft234/admin/logout" class="logout">خروج</a>
    </div>
    
    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <h3><?= $total_users ?></h3>
                <p>تعداد کاربران</p>
            </div>
            <div class="stat-card">
                <h3><?= $total_requests ?></h3>
                <p>درخواست‌های فروش</p>
            </div>
            <div class="stat-card">
                <h3><?= $total_types ?></h3>
                <p>انواع ضایعات</p>
            </div>
        </div>

        <div class="card" style="margin-bottom: 40px; background: #1e293b; padding: 20px; border-radius: 16px;">
            <canvas id="myChart" height="100"></canvas>
        </div>
        
        <div class="menu">
            <div class="menu-item">
                <a href="admin/requests">
                    <h2>📋</h2>
                    <p>مدیریت درخواست‌های فروش</p>
                </a>
            </div>
            <div class="menu-item">
                <a href="admin/users">
                    <h2>👥</h2>
                    <p>مدیریت کاربران</p>
                </a>
            </div>
            <div class="menu-item">
                <a href="admin/recycling">
                    <h2>♻️</h2>
                    <p>مدیریت انواع ضایعات</p>
                </a>
            </div>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'تعداد درخواست‌های فروش ۷ روز اخیر',
                data: <?= json_encode($data) ?>,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { labels: { color: '#e2e8f0', font: { family: 'Tahoma' } } }
            }
        }
    });
    </script>
</body>
</html>
