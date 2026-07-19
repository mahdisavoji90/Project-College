<style>
    /* ========================================
   استایل‌های صفحه پروفایل
   ======================================== */
   /* ========================================
   استایل‌های صفحه درخواست‌ها
   ======================================== */

/* وضعیت‌های جدید */
/* ===== تنظیمات کلی هدر ===== */
.container.header-inner {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    padding: 14px 28px;
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0,0,0,0.25);
    gap: 14px;
    border-bottom: 2px solid #22d3ee;
}

/* ===== کنترل‌های کاربر ===== */
.controls-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-welcome {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.06);
    padding: 5px 14px 5px 10px;
    border-radius: 25px;
    border: 1px solid rgba(255,255,255,0.08);
}

.user-welcome span {
    color: #cbd5e6;
    font-size: 13px;
    font-weight: 500;
}

.auth-buttons {
    display: flex;
    gap: 8px;
}

.btn {
    padding: 7px 18px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    border: none;
}

.btn-outline {
    border: 1.5px solid #475569;
    color: #94a3b8;
    background: transparent;
}

.btn-outline:hover {
    background: #22d3ee;
    color: #0f172a;
    border-color: #22d3ee;
    transform: translateY(-1px);
}

.btn-primary {
    background: #22d3ee;
    color: #0f172a;
}

.btn-primary:hover {
    background: #06b6d4;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(34, 211, 238, 0.3);
}

/* ===== لوگو ===== */
.logo {
    text-align: center;
}

.logo h1 {
    font-size: 26px;
    font-weight: 800;
    color: #ffffff;
    margin: 0;
    letter-spacing: 0.5px;
}

.logo h1 span {
    color: #22d3ee;
}

.logo p {
    font-size: 12px;
    color: #64748b;
    margin: 2px 0 0 0;
    font-weight: 300;
}

/* ===== نوار جستجو ===== */
.search-bar {
    display: flex;
    align-items: center;
    flex: 1 1 240px;
    min-width: 180px;
    background: rgba(255,255,255,0.05);
    border-radius: 30px;
    border: 1px solid rgba(255,255,255,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-bar:focus-within {
    border-color: #22d3ee;
    box-shadow: 0 0 25px rgba(34, 211, 238, 0.08);
    background: rgba(255,255,255,0.08);
}

.search-bar input {
    flex: 1;
    padding: 9px 16px;
    background: transparent;
    border: none;
    color: #e2e8f0;
    font-size: 13px;
    outline: none;
    direction: rtl;
}

.search-bar input::placeholder {
    color: #475569;
    font-size: 12px;
}

.search-bar button {
    padding: 9px 14px;
    background: transparent;
    border: none;
    color: #64748b;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.search-bar button:hover {
    color: #22d3ee;
}

/* ===== دسته‌بندی ===== */
.quick-categories {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
}

.quick-categories a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 12px;
    padding: 4px 14px;
    border-radius: 20px;
    transition: all 0.25s ease;
    border: 1px solid transparent;
}

.quick-categories a:hover {
    color: #ffffff;
    border-color: rgba(34, 211, 238, 0.2);
    background: rgba(34, 211, 238, 0.06);
}

/* ===== اکشن‌ها (سبد خرید + اعلان) ===== */
.actions {
    display: flex;
    align-items: center;
    gap: 6px;
}

.cart-icon,
.notifications {
    position: relative;
    color: #94a3b8;
    font-size: 20px;
    padding: 7px 10px;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.25s ease;
    border: 1px solid transparent;
}

.cart-icon:hover,
.notifications:hover {
    color: #ffffff;
    background: rgba(255,255,255,0.04);
    border-color: rgba(255,255,255,0.06);
}

.cart-count,
.notif-count {
    position: absolute;
    top: -4px;
    right: -2px;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 50%;
    min-width: 18px;
    text-align: center;
}

.cart-count {
    background: #22d3ee;
    color: #0f172a;
}

.notif-count {
    background: #f59e0b;
    color: #0f172a;
}

/* ===== ریسپانسیو ===== */

/* تبلت */
@media (max-width: 1024px) {
    .container.header-inner {
        padding: 12px 20px;
        gap: 10px;
    }
    
    .logo h1 {
        font-size: 22px;
    }
    
    .quick-categories a {
        font-size: 11px;
        padding: 3px 10px;
    }
}

/* موبایل */
@media (max-width: 768px) {
    .container.header-inner {
        flex-direction: column;
        align-items: stretch;
        padding: 12px 16px;
        gap: 10px;
    }
    
    .controls-wrapper {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .logo h1 {
        font-size: 20px;
        text-align: center;
    }
    
    .logo p {
        font-size: 11px;
        text-align: center;
    }
    
    .search-bar {
        flex: 1 1 100%;
    }
    
    .quick-categories {
        justify-content: center;
        gap: 4px;
    }
    
    .quick-categories a {
        font-size: 11px;
        padding: 3px 10px;
    }
    
    .actions {
        justify-content: center;
    }
    
    .user-welcome span {
        font-size: 12px;
    }
    
    .btn {
        font-size: 12px;
        padding: 6px 14px;
    }
}

/* موبایل خیلی کوچک */
@media (max-width: 480px) {
    .container.header-inner {
        padding: 10px 12px;
        gap: 8px;
    }
    
    .logo h1 {
        font-size: 17px;
    }
    
    .quick-categories a {
        font-size: 10px;
        padding: 2px 8px;
    }
    
    .cart-icon,
    .notifications {
        font-size: 17px;
        padding: 5px 8px;
    }
}
.status.in-progress {
    background: rgba(99, 102, 241, 0.15);
    color: #818cf8;
}

.status.in-progress::before {
    background: #818cf8;
    animation: pulse 1.5s infinite;
}

.status.cancelled {
    background: rgba(100, 116, 139, 0.15);
    color: #94a3b8;
}

.status.cancelled::before {
    background: #94a3b8;
}

.status.rejected {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
}

.status.rejected::before {
    background: #f87171;
}

/* فرم درخواست جدید */
#newRequestForm {
    animation: slideIn 0.3s ease-out;
}

#newRequestForm select {
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 12px 16px;
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: var(--transition);
    font-family: inherit;
    width: 100%;
}

#newRequestForm select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

#newRequestForm select option {
    background: var(--bg-dark);
    color: var(--text-primary);
}

/* بهبود دکمه‌های جدول */
.table-container .btn {
    padding: 4px 10px;
    font-size: 0.75rem;
    border-radius: 8px;
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: stretch !important;
    }
    
    .page-header .btn {
        width: 100%;
        justify-content: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}

/* پیام‌های هشدار */
.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-weight: 500;
    animation: slideIn 0.3s ease-out;
    border-right: 4px solid transparent;
}

.alert-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid #22c55e;
    color: #4ade80;
    border-right-color: #22c55e;
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid #ef4444;
    color: #f87171;
    border-right-color: #ef4444;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* بخش عکس پروفایل */
.profile-picture-section {
    display: flex;
    align-items: center;
    gap: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 30px;
}

.current-picture {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid var(--primary);
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
}

.current-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.picture-info h3 {
    color: var(--text-primary);
    font-size: 1.2rem;
    margin-bottom: 6px;
}

.picture-info p {
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin: 2px 0;
}

.picture-info .email-display {
    color: var(--primary-light);
    font-weight: 500;
    margin-top: 6px;
}

/* فرم پروفایل */
.profile-form {
    margin-bottom: 30px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 0.9rem;
}

.form-group .required {
    color: var(--danger);
}

.form-group input,
.form-group textarea {
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 12px 16px;
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: var(--transition);
    font-family: inherit;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-group input:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: var(--bg-card);
}

.form-group input[type="file"] {
    display: none;
}

.form-group small {
    color: var(--text-muted);
    font-size: 0.75rem;
    margin-top: 4px;
}

/* آپلود فایل */
.file-input-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.file-input-label {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 10px 24px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: var(--transition);
    display: inline-block;
}

.file-input-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.4);
}

.file-name {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* دکمه‌های فرم */
.form-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 10px;
}

/* اطلاعات حساب */
.account-info {
    background: var(--bg-dark);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid var(--border-color);
}

.account-info h3 {
    color: var(--text-primary);
    font-size: 1.1rem;
    margin-bottom: 16px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: var(--bg-card);
    border-radius: 10px;
    border: 1px solid var(--border-color);
}

.info-label {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.info-value {
    color: var(--primary-light);
    font-weight: 600;
    font-size: 0.9rem;
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .profile-picture-section {
        flex-direction: column;
        text-align: center;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .file-input-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    
    .file-input-label {
        text-align: center;
    }
}
    /* ========================================
   فونت و ریشه
   ======================================== */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --primary-light: #818cf8;
    --primary-bg: #eef2ff;
    --secondary: #0f172a;
    --bg-dark: #0b1120;
    --bg-card: #1e293b;
    --bg-card-hover: #2d3a4e;
    --border-color: #334155;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --text-muted: #64748b;
    --success: #22c55e;
    --success-bg: #052e16;
    --warning: #eab308;
    --warning-bg: #422006;
    --danger: #ef4444;
    --danger-bg: #450a0a;
    --radius: 20px;
    --shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    background: var(--bg-dark);
    color: var(--text-primary);
    line-height: 1.6;
    min-height: 100vh;
    direction: rtl;
}

/* ========================================
   کانتینر اصلی
   ======================================== */
.dashboard-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ========================================
   هدر
   ======================================== */
.dashboard-header {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    border-bottom: 1px solid var(--border-color);
    padding: 20px 40px;
    position: sticky;
    top: 0;
    z-index: 50;
    backdrop-filter: blur(12px);
    background: rgba(15, 23, 42, 0.9);
}

.header-content {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.logo-icon {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 900;
    color: white;
}

.logo-text {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #818cf8, #c084fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-right .date {
    color: var(--text-secondary);
    font-size: 0.9rem;
    background: var(--bg-card);
    padding: 6px 16px;
    border-radius: 40px;
    border: 1px solid var(--border-color);
}

.user-profile-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--bg-card);
    padding: 6px 12px 6px 20px;
    border-radius: 40px;
    border: 1px solid var(--border-color);
    cursor: pointer;
    transition: var(--transition);
}

.user-profile-btn:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.2);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
}

.user-name {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.9rem;
}

/* ========================================
   بدنه اصلی (سایدبار + محتوا)
   ======================================== */
.dashboard-body {
    flex: 1;
    display: flex;
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
    padding: 24px 24px 0 24px;
    gap: 24px;
}

/* ========================================
   سایدبار
   ======================================== */
.sidebar {
    width: 260px;
    flex-shrink: 0;
    background: var(--bg-card);
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 20px 0;
    height: fit-content;
    position: sticky;
    top: 100px;
    box-shadow: var(--shadow);
}

.sidebar-user {
    padding: 0 20px 20px 20px;
    border-bottom: 1px solid var(--border-color);
    text-align: center;
    margin-bottom: 16px;
}

.sidebar-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    margin: 0 auto 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
    color: white;
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
}

.sidebar-username {
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--text-primary);
}

.sidebar-role {
    font-size: 0.8rem;
    color: var(--text-secondary);
    background: var(--bg-dark);
    padding: 2px 14px;
    border-radius: 20px;
    display: inline-block;
    margin-top: 4px;
}

.sidebar-menu {
    list-style: none;
    padding: 0 12px;
}

.sidebar-menu li {
    margin-bottom: 2px;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: 12px;
    transition: var(--transition);
    font-weight: 500;
    font-size: 0.95rem;
}

.sidebar-menu a .icon {
    font-size: 1.3rem;
    width: 32px;
    text-align: center;
    flex-shrink: 0;
}

.sidebar-menu a .badge {
    margin-right: auto;
    background: var(--danger);
    color: white;
    padding: 0 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    line-height: 20px;
}

.sidebar-menu a:hover {
    background: rgba(99, 102, 241, 0.1);
    color: var(--text-primary);
}

.sidebar-menu a.active {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.05));
    color: var(--primary-light);
    border-left: 3px solid var(--primary);
}

.sidebar-divider {
    height: 1px;
    background: var(--border-color);
    margin: 12px 16px;
}

/* ========================================
   محتوای اصلی
   ======================================== */
.main-content {
    flex: 1;
    min-width: 0;
}

/* ========================================
   هدر صفحه
   ======================================== */
.page-header {
    background: var(--bg-card);
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 24px 32px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
}

.page-header h1 {
    font-size: 1.8rem;
    font-weight: 800;
    background: linear-gradient(135deg, #f1f5f9, #94a3b8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-header p {
    color: var(--text-secondary);
    margin-top: 4px;
}

/* ========================================
   کارت‌های آمار
   ======================================== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.stat-card {
    background: var(--bg-card);
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 24px;
    box-shadow: var(--shadow);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 4px;
    height: 100%;
    border-radius: 0 4px 4px 0;
}

.stat-card:nth-child(1)::before {
    background: linear-gradient(180deg, #6366f1, #8b5cf6);
}

.stat-card:nth-child(2)::before {
    background: linear-gradient(180deg, #22c55e, #4ade80);
}

.stat-card:nth-child(3)::before {
    background: linear-gradient(180deg, #f59e0b, #fbbf24);
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: var(--primary);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
}

.stat-card .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 12px;
}

.stat-card:nth-child(1) .stat-icon {
    background: rgba(99, 102, 241, 0.15);
}

.stat-card:nth-child(2) .stat-icon {
    background: rgba(34, 197, 94, 0.15);
}

.stat-card:nth-child(3) .stat-icon {
    background: rgba(245, 158, 11, 0.15);
}

.stat-card .stat-label {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 4px;
}

.stat-card .stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-primary);
}

.stat-card .stat-change {
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 8px;
    display: inline-block;
    padding: 2px 12px;
    border-radius: 20px;
}

.stat-change.positive {
    color: var(--success);
    background: var(--success-bg);
}

.stat-change.negative {
    color: var(--danger);
    background: var(--danger-bg);
}

/* ========================================
   کارت‌ها
   ======================================== */
.card {
    background: var(--bg-card);
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
}

.card-header .card-action {
    color: var(--primary-light);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    transition: var(--transition);
}

.card-header .card-action:hover {
    color: var(--primary);
}

/* ========================================
   جدول
   ======================================== */
.table-container {
    overflow-x: auto;
    margin: -8px -8px 0 -8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

table thead {
    background: var(--bg-dark);
    border-radius: 12px;
}

table th {
    text-align: right;
    padding: 14px 16px;
    color: var(--text-secondary);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

table td {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
}

table tbody tr {
    transition: var(--transition);
}

table tbody tr:hover {
    background: rgba(255, 255, 255, 0.02);
}

table tbody tr:last-child td {
    border-bottom: none;
}

/* ========================================
   وضعیت‌ها
   ======================================== */
.status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px;
    border-radius: 40px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.status.success {
    background: var(--success-bg);
    color: #4ade80;
}

.status.success::before {
    background: #4ade80;
}

.status.pending {
    background: var(--warning-bg);
    color: #fbbf24;
}

.status.pending::before {
    background: #fbbf24;
    animation: pulse 1.5s infinite;
}

.status.failed {
    background: var(--danger-bg);
    color: #f87171;
}

.status.failed::before {
    background: #f87171;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* ========================================
   بخش سریع
   ======================================== */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
}

.quick-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px;
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    color: var(--text-secondary);
    text-decoration: none;
    transition: var(--transition);
    font-weight: 500;
    font-size: 0.85rem;
}

.quick-btn:hover {
    border-color: var(--primary);
    color: var(--text-primary);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.15);
}

.quick-btn .qb-icon {
    font-size: 28px;
}

/* ========================================
   ریسپانسیو
   ======================================== */
@media (max-width: 1024px) {
    .dashboard-body {
        flex-direction: column;
        padding: 16px 16px 0 16px;
    }

    .sidebar {
        width: 100%;
        position: static;
        display: flex;
        flex-wrap: wrap;
        padding: 16px;
        gap: 4px;
    }

    .sidebar-user {
        width: 100%;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 16px;
        margin-bottom: 12px;
    }

    .sidebar-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        padding: 0;
        width: 100%;
    }

    .sidebar-menu li {
        flex: 1;
        min-width: 120px;
    }

    .sidebar-menu a {
        padding: 10px 14px;
        justify-content: center;
        font-size: 0.85rem;
    }

    .sidebar-menu a .badge {
        margin-right: 4px;
    }

    .sidebar-divider {
        display: none;
    }

    .header-content {
        flex-wrap: wrap;
        gap: 12px;
    }

    .header-right .date {
        display: none;
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 12px 16px;
    }

    .logo-text {
        font-size: 1.2rem;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .page-header {
        padding: 16px 20px;
    }

    .page-header h1 {
        font-size: 1.4rem;
    }

    .card {
        padding: 16px 18px;
    }

    .quick-actions {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .quick-actions {
        grid-template-columns: 1fr;
    }

    .sidebar-menu li {
        min-width: 100%;
    }

    .user-profile-btn .user-name {
        display: none;
    }
}
    /* ========== صفحه پروفایل ========== */
.profile-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    padding: 100px 20px 40px;
}

.profile-container {
    max-width: 1000px;
    margin: 0 auto;
}

.profile-header-section {
    text-align: center;
    margin-bottom: 40px;
}

.profile-header-section h1 {
    font-size: 2.5rem;
    background: linear-gradient(135deg, #2dd4bf, #10b981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.profile-header-section p {
    color: #94a3b8;
    font-size: 1.1rem;
}

/* Alert ها */
.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-weight: 500;
    animation: slideIn 0.3s ease-out;
}

.alert-success {
    background: linear-gradient(135deg, #10b98120, #2dd4bf20);
    border: 1px solid #10b981;
    color: #2dd4bf;
}

.alert-error {
    background: linear-gradient(135deg, #ef444420, #dc262620);
    border: 1px solid #ef4444;
    color: #ef4444;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideOut {
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

/* محتوای پروفایل */
.profile-content {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    border: 1px solid #334155;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

/* بخش عکس پروفایل */
.profile-picture-section {
    display: flex;
    align-items: center;
    gap: 30px;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #334155;
}

.current-picture {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #2dd4bf;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(45, 212, 191, 0.3);
    flex-shrink: 0;
}

.current-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.picture-info h3 {
    color: #f1f5f9;
    font-size: 1.3rem;
    margin-bottom: 10px;
}

.picture-info p {
    color: #94a3b8;
    font-size: 0.9rem;
    margin: 4px 0;
}

/* فرم */
.profile-form {
    margin-bottom: 40px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-bottom: 30px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    color: #f1f5f9;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.required {
    color: #ef4444;
}

.form-group input,
.form-group textarea {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 12px 16px;
    color: #f1f5f9;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #2dd4bf;
    box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.1);
}

.form-group input:disabled {
    background: #1e293b;
    color: #64748b;
    cursor: not-allowed;
}

.form-group small {
    color: #64748b;
    font-size: 0.8rem;
    margin-top: 4px;
}

/* آپلود فایل سفارشی */
.file-input-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}

.file-input-wrapper input[type="file"] {
    display: none;
}

.file-input-label {
    background: linear-gradient(135deg, #2dd4bf, #10b981);
    color: #0f172a;
    padding: 12px 24px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-block;
}

.file-input-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(45, 212, 191, 0.4);
}

.file-name {
    color: #94a3b8;
    font-size: 0.9rem;
}

/* دکمه‌های فرم */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
}

.btn {
    padding: 14px 32px;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #2dd4bf, #10b981);
    color: #0f172a;
    box-shadow: 0 4px 12px rgba(45, 212, 191, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(45, 212, 191, 0.4);
}

.btn-outline {
    background: transparent;
    border: 2px solid #334155;
    color: #94a3b8;
}

.btn-outline:hover {
    border-color: #2dd4bf;
    color: #2dd4bf;
}

/* اطلاعات حساب */
.account-info {
    background: linear-gradient(135deg, #2dd4bf10, transparent);
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 30px;
}

.account-info h3 {
    color: #f1f5f9;
    font-size: 1.3rem;
    margin-bottom: 20px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: #0f172a;
    border-radius: 10px;
}

.info-label {
    color: #94a3b8;
    font-size: 0.9rem;
}

.info-value {
    color: #2dd4bf;
    font-weight: 600;
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .profile-content {
        padding: 24px;
    }
    
    .profile-picture-section {
        flex-direction: column;
        text-align: center;
    }
    
    .form-grid,
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .file-input-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    
    .file-input-label {
        text-align: center;
    }
}

    /* ========== منوی سایدبار پروفایل ========== */
.profile-sidebar {
    position: fixed;
    top: 0;
    right: -320px; /* پنهان در ابتدا */
    width: 320px;
    height: 100vh;
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
    border-left: 1px solid #334155;
    box-shadow: -8px 0 30px rgba(0, 0, 0, 0.5);
    z-index: 1000;
    transition: right 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.profile-sidebar.active {
    right: 0; /* نمایش منو */
}

/* هدر سایدبار */
.sidebar-header {
    padding: 32px 24px;
    text-align: center;
    border-bottom: 1px solid #334155;
    background: linear-gradient(135deg, #2dd4bf15, transparent);
}

.profile-avatar {
    width: 80px;
    height: 80px;
    margin: 0 auto 16px;
    border-radius: 50%;
    border: 3px solid #2dd4bf;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(45, 212, 191, 0.3);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #f1f5f9;
    margin-bottom: 8px;
}

.profile-level {
    display: inline-block;
    background: linear-gradient(135deg, #cd7f32, #b8860b);
    color: #fff;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* منوی ناوبری */
.sidebar-menu {
    flex: 1;
    padding: 16px 0;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 24px;
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.2s;
    position: relative;
    border-right: 3px solid transparent;
}

.menu-item:hover {
    background: #2d3a4e;
    color: #2dd4bf;
    border-right-color: #2dd4bf;
}

.menu-item.active {
    background: linear-gradient(90deg, #2dd4bf20, transparent);
    color: #2dd4bf;
    border-right-color: #2dd4bf;
    font-weight: 600;
}

.menu-icon {
    font-size: 1.3rem;
    width: 28px;
    text-align: center;
}

.menu-text {
    flex: 1;
    font-size: 0.95rem;
}

.badge {
    background: #ef4444;
    color: #fff;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
}

/* فوتر سایدبار */
.sidebar-footer {
    padding: 20px 24px;
    border-top: 1px solid #334155;
}

.btn-logout {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    border: none;
    border-radius: 20px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-logout:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
}

/* overlay تیره */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* دکمه همبرگری (toggle) */
.sidebar-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #2dd4bf, #10b981);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    z-index: 998;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    box-shadow: 0 4px 12px rgba(45, 212, 191, 0.4);
    transition: all 0.3s;
}

.sidebar-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(45, 212, 191, 0.6);
}

.sidebar-toggle span {
    width: 22px;
    height: 3px;
    background: #0f172a;
    border-radius: 2px;
    transition: all 0.3s;
}

.sidebar-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.sidebar-toggle.active span:nth-child(2) {
    opacity: 0;
}

.sidebar-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* اسکرول‌بار سفارشی */
.profile-sidebar::-webkit-scrollbar {
    width: 6px;
}

.profile-sidebar::-webkit-scrollbar-track {
    background: #0f172a;
}

.profile-sidebar::-webkit-scrollbar-thumb {
    background: #2dd4bf;
    border-radius: 10px;
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .profile-sidebar {
        width: 280px;
        right: -280px;
    }
    
    .sidebar-toggle {
        top: 16px;
        right: 16px;
        width: 44px;
        height: 44px;
    }
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, 'Segoe UI', 'Tahoma', sans-serif;
            background: #0b1120;
            color: #e2e8f0;
            line-height: 1.5;
        }

        /* container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* header - تیره مدرن */
        .site-header {
            background: #0f172ad9;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #2d3a4e;
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 16px 0;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .logo h1 {
            font-size: 1.7rem;
            font-weight: 600;
            background: linear-gradient(135deg, #2dd4bf, #10b981);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .logo p {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .auth-buttons {
            display: flex;
            gap: 12px;
        }
        .btn {
            border: none;
            background: transparent;
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-outline {
            border: 1px solid #2dd4bf;
            color: #2dd4bf;
            background: transparent;
        }
        .btn-outline:hover {
            background: #2dd4bf20;
            transform: translateY(-2px);
        }
        .btn-primary {
            background: #10b981;
            color: #0f172a;
            font-weight: 600;
            box-shadow: 0 2px 8px #10b98130;
        }
        .btn-primary:hover {
            background: #2dd4bf;
            transform: translateY(-2px);
        }
        .user-welcome {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #1e293b;
            padding: 6px 16px;
            border-radius: 40px;
            border: 1px solid #334155;
        }
        .user-welcome span {
            font-weight: 500;
            color: #a7f3d0;
        }

        /* footer تیره */
        footer {
            margin-top: 80px;
            background: #0f172a;
            border-top: 1px solid #1e2a3a;
            padding: 32px 0 24px;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .footer-links a {
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.9rem;
        }
        .footer-links a:hover { color: #2dd4bf; }
        .copyright {
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
        }

        /* views */
        .view {
            display: none;
            animation: fade 0.2s ease;
        }
        .active-view { display: block; }
        @keyframes fade { from { opacity: 0; } to { opacity: 1; } }

        /* slider تیره */
        .slider-container {
            margin: 40px 0 32px;
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
        }
        .slider {
            display: flex;
            transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            width: 100%;  
        }
        .slide {
            min-width: 100%;
            cursor: pointer;
            position: relative;
        }
        .slide img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
            filter: brightness(0.85);
        }
        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #1e293bcc;
            border: 1px solid #2dd4bf;
            font-size: 1.8rem;
            width: 44px;
            height: 44px;
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(4px);
            font-weight: bold;
            color: #2dd4bf;
            transition: 0.2s;
        }
        .slider-btn:hover {
            background: #10b981;
            color: #0f172a;
            border-color: #10b981;
        }
        .prev { left: 16px; }
        .next { right: 16px; }

        /* section title */
        .section-title {
            font-size: 1.7rem;
            font-weight: 600;
            margin: 48px 0 24px 0;
            border-right: 5px solid #2dd4bf;
            padding-right: 16px;
            color: #f1f5f9;
        }

        /* price list modern dark */
        .price-list-modern {
            background: #1e293b;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #334155;
            margin-bottom: 40px;
        }
        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid #334155;
            transition: background 0.1s;
        }
        .price-item:last-child { border-bottom: none; }
        .price-item:hover { background: #2d3a4e; }
        .item-name {
            font-weight: 600;
            font-size: 1.05rem;
            color: #cbd5e1;
        }
        .item-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #a7f3d0;
            background: #0f172a;
            padding: 6px 14px;
            border-radius: 40px;
            border: 1px solid #2dd4bf40;
        }

        /* request card dark */
        .request-card {
            background: #1e293b;
            border-radius: 28px;
            padding: 32px;
            margin: 32px 0;
            border: 1px solid #334155;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #cbd5e6;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #475569;
            border-radius: 20px;
            font-family: inherit;
            font-size: 0.95rem;
            background: #0f172a;
            color: #f1f5f9;
            transition: 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #2dd4bf;
            box-shadow: 0 0 0 3px #2dd4bf20;
        }
        .success-msg {
            background: #064e3b;
            color: #a7f3d0;
            padding: 14px;
            border-radius: 20px;
            margin-bottom: 20px;
            border-right: 4px solid #2dd4bf;
        }
        .prev-requests-list {
            margin-top: 32px;
            border-top: 2px solid #334155;
            padding-top: 24px;
        }
        .request-item {
            background: #0f172a;
            border-radius: 18px;
            padding: 14px 18px;
            margin-bottom: 12px;
            border: 1px solid #2d3a4e;
        }

        .detail-card {
            background: #1e293b;
            border-radius: 28px;
            padding: 32px;
            margin: 32px 0;
            border: 1px solid #334155;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .back-home {
            margin-top: 16px;
            margin-bottom: 40px;
        }
        .login-card {
            max-width: 500px;
            margin: 48px auto;
            background: #1e293b;
            border-radius: 32px;
            padding: 32px;
            border: 1px solid #334155;
            box-shadow: 0 20px 35px -12px black;
        }
        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 28px;
            border-bottom: 2px solid #334155;
        }
        .tab-btn {
            background: none;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            color: #94a3b8;
            transition: 0.2s;
        }
        .tab-btn.active {
            color: #2dd4bf;
            border-bottom: 3px solid #2dd4bf;
            margin-bottom: -2px;
        }
        hr { margin: 20px 0; border-color: #334155; }
        @media (max-width: 700px) {
            .slide img { height: 260px; }
            .price-item { flex-direction: column; align-items: flex-start; gap: 8px; }
        }
        .text-center { text-align: center; }
        ::placeholder { color: #64748b; }

        .header-inner {
            display: flex;
            justify-content: space-between; /* لوگو را به سمت راست و دکمه ها را به سمت چپ هل می دهد */
            align-items: center;
        }

        .controls-wrapper {
            order: 2; /* اطمینان از اینکه در سمت چپ است */
        }

        .logo {
            order: 1; /* اطمینان از اینکه در سمت راست است */
        }

        /* ====== RESET & BASE ====== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', 'Tahoma', sans-serif;
            background: #121212;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ====== FOOTER تیره ====== */
        footer {
            background: #0a0a0a;
            color: #b0b0b0;
            padding: 60px 0 0 0;
            margin-top: auto;
            border-top: 3px solid #2ecc71;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        /* دکور بالا - نئونی */
        footer::before {
            content: '';
            position: absolute;
            top: -3px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #2ecc71, #27ae60, #2ecc71, #27ae60);
            background-size: 300% 100%;
            animation: neonMove 4s infinite linear;
            box-shadow: 0 0 20px rgba(46, 204, 113, 0.3);
        }

        @keyframes neonMove {
            0% { background-position: 0% 0; }
            100% { background-position: 300% 0; }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ====== GRID FOOTER ====== */
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* ====== ستون اول: درباره ====== */
        .footer-about h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2ecc71;
            display: flex;
            align-items: center;
            gap: 10px;
            text-shadow: 0 0 20px rgba(46, 204, 113, 0.2);
        }

        .footer-about h3 i {
            font-size: 30px;
            color: #f1c40f;
            text-shadow: 0 0 30px rgba(241, 196, 15, 0.3);
        }

        .footer-about p {
            line-height: 1.8;
            font-size: 15px;
            color: #888;
            margin-bottom: 20px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            color: #666;
            font-size: 18px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-social a:hover {
            background: #2ecc71;
            color: #0a0a0a;
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 30px rgba(46, 204, 113, 0.4);
            border-color: #2ecc71;
        }

        /* ====== ستون‌های لینک ====== */
        .footer-col h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 18px;
            color: #e0e0e0;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 40px;
            height: 2px;
            background: #2ecc71;
            border-radius: 2px;
            box-shadow: 0 0 15px rgba(46, 204, 113, 0.3);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: #777;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-col ul li a i {
            font-size: 12px;
            color: #2ecc71;
            opacity: 0;
            transform: translateX(-8px);
            transition: all 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: #2ecc71;
            transform: translateX(5px);
            text-shadow: 0 0 20px rgba(46, 204, 113, 0.2);
        }

        .footer-col ul li a:hover i {
            opacity: 1;
            transform: translateX(0);
        }

        /* ====== ستون تماس ====== */
        .footer-contact ul li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #777;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-contact ul li i {
            color: #2ecc71;
            font-size: 18px;
            width: 20px;
            margin-top: 3px;
        }

        /* ====== لینک‌های پایین ====== */
        .footer-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px 30px;
            padding: 30px 0 20px 0;
        }

        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            padding: 0 4px;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            right: 0;
            width: 0;
            height: 2px;
            background: #2ecc71;
            transition: width 0.3s ease;
            box-shadow: 0 0 15px rgba(46, 204, 113, 0.3);
        }

        .footer-links a:hover {
            color: #2ecc71;
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        .footer-links .separator {
            color: rgba(255, 255, 255, 0.05);
            user-select: none;
        }

        /* ====== کپی‌رایت ====== */
        .copyright {
            text-align: center;
            padding: 20px 0 25px 0;
            font-size: 14px;
            color: #555;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            margin-top: 5px;
        }

        .copyright span {
            color: #2ecc71;
            font-weight: 600;
            text-shadow: 0 0 20px rgba(46, 204, 113, 0.2);
        }

        .copyright i {
            color: #e74c3c;
            animation: heartbeat 1.5s infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.2); }
            50% { transform: scale(1); }
        }

        .copyright small {
            color: #444;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 992px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 576px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 25px;
                text-align: center;
            }

            .footer-about h3 {
                justify-content: center;
            }

            .footer-social {
                justify-content: center;
            }

            .footer-col h4::after {
                right: 50%;
                transform: translateX(50%);
            }

            .footer-col ul li a {
                justify-content: center;
            }

            .footer-contact ul li {
                justify-content: center;
            }

            .footer-links {
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }

            .footer-links .separator {
                display: none;
            }
        }

        /* ====== اسکرول به بالا - تیره ====== */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #2ecc71;
            color: #0a0a0a;
            border: none;
            border-radius: 50%;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 4px 25px rgba(46, 204, 113, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 40px rgba(46, 204, 113, 0.5);
            background: #27ae60;
        }
    </style>