# Backend structure changes

این بازسازی فقط ساختار بک‌اند را تغییر داده است. فایل‌های ظاهری، تصاویر، CSS و JavaScript دست‌نخورده باقی مانده‌اند.

## نقاط ورود

- `bootstrap.php`: آغاز Session، بارگذاری تنظیمات و ایجاد اتصال مشترک دیتابیس
- `router.php`: Front Controller مرکزی
- `routes/web.php`: تعریف مسیرهای عمومی، کاربری و مدیریت
- `app/Core/Router.php`: مسیریاب سبک PHP
- `app/Core/Database.php`: اتصال Singleton مبتنی بر PDO
- `config/database.php`: تنظیمات متمرکز دیتابیس

## مسیرهای جدید

- `/`
- `/login`
- `/logout`
- `/dashboard`
- `/profile`
- `/settings`
- `/addresses`
- `/requests`
- `/request?id=...`
- `/transactions`
- `/wallet`
- `/rewards`
- `/notifications`
- `/admin/login`
- `/admin/logout`
- `/admin`
- `/admin/users`
- `/admin/recycling`
- `/admin/requests`

آدرس‌های قدیمی PHP نیز همچنان قابل استفاده‌اند، چون فایل‌های صفحه جابه‌جا نشده‌اند.

## راه‌اندازی Apache

`mod_rewrite` باید فعال باشد و `AllowOverride All` برای پوشه پروژه مجاز باشد. فایل `.htaccess` درخواست‌های مسیر تمیز را به `router.php` می‌فرستد و فایل‌های واقعی مانند تصاویر و CSS را مستقیماً سرو می‌کند.

## تنظیم دیتابیس

متغیرهای محیطی مطابق `.env.example` تنظیم شوند. اگر تنظیم نشده باشند، مقادیر پیش‌فرض توسعه محلی استفاده می‌شوند.
