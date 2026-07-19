<h1 align="center">بازیافت نوین (Baziaft) ♻️</h1>
<h3 align="center">Modern Recycling Management System</h3>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8%2B-777BB4?style=flat-square&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="License">
</p>

---

# 🇮🇷 فارسی

> **سیستم خرید و فروش آنلاین ضایعات (الکترونیک، فلزات، پلاستیک، کاغذ)**  
> یک پلتفرم وب برای مدیریت و ثبت درخواست‌های فروش ضایعات با پنل مدیریت کامل

## 📋 فهرست مطالب

- [معرفی پروژه](#معرفی-پروژه)
- [ویژگی‌ها](#ویژگی‌ها)
- [تکنولوژی‌های استفاده شده](#تکنولوژی‌های-استفاده-شده)
- [نصب و راه‌اندازی](#نصب-و-راه‌اندازی)
- [ساختار پروژه](#ساختار-پروژه)
- [مسیریابی](#مسیریابی)
- [پنل مدیریت](#پنل-مدیریت)
- [دیتابیس](#دیتابیس)
- [امنیت](#امنیت)
- [مشارکت](#مشارکت)
- [لایسنس](#لایسنس)

---

## 🚀 معرفی پروژه

**بازیافت نوین** یک وب‌سایت خرید و فروش آنلاین ضایعات است که به کاربران امکان می‌دهد:

- ثبت‌نام و ایجاد حساب کاربری
- مشاهده قیمت‌های به‌روز انواع ضایعات (الکترونیک، فلزات، پلاستیک، کاغذ و...)
- ثبت درخواست فروش ضایعات
- مدیریت کیف پول و مشاهده تراکنش‌ها
- دریافت امتیاز و جوایز
- مدیریت آدرس‌ها و پروفایل شخصی
- دریافت اعلان‌ها

همچنین **پنل مدیریت** قدرتمندی برای مدیران سیستم فراهم شده است تا بتوانند:

- مدیریت کاربران
- مدیریت انواع ضایعات و قیمت‌ها
- مدیریت و تایید درخواست‌های فروش
- مشاهده آمار و نمودارهای تحلیلی

---

## ✨ ویژگی‌ها

### 👤 بخش کاربری
- ✅ سیستم ثبت‌نام و ورود امن با رمزنگاری Bcrypt
- ✅ داشبورد شخصی با نمایش آمار و اطلاعات حساب
- ✅ سیستم سطح‌بندی کاربران (برنزی، نقره‌ای، طلایی، الماسی، VIP)
- ✅ کیف پول دیجیتال و مدیریت تراکنش‌ها
- ✅ سیستم امتیاز و جوایز
- ✅ مدیریت آدرس‌های کاربر
- ✅ ثبت درخواست فروش ضایعات
- ✅ پنل اعلان‌ها
- ✅ تم تیره (Dark Theme) مدرن و واکنش‌گرا

### 🔐 بخش مدیریت
- ✅ داشبورد مدیریت با نمودارهای تحلیلی (Chart.js)
- ✅ مدیریت کاربران (جستجو، ویرایش، حذف)
- ✅ مدیریت انواع ضایعات و قیمت‌گذاری
- ✅ مدیریت و بررسی درخواست‌های فروش
- ✅ سیستم ورود مجزا برای مدیران

---

## 🛠️ تکنولوژی‌های استفاده شده

| تکنولوژی | توضیحات |
|----------|---------|
| **PHP 8+** | زبان برنامه‌نویسی سمت سرور با `declare(strict_types=1)` |
| **MySQL/MariaDB** | دیتابیس رابطه‌ای |
| **PDO** | اتصال به دیتابیس با الگوی Singleton |
| **Apache** | وب سرور با ماژول mod_rewrite |
| **HTML5 & CSS3** | ساختار و استایل با تم تیره (Dark Theme) |
| **JavaScript (Vanilla)** | اسکریپت‌های کلاینت‌ساید |
| **Chart.js** | کتابخانه نمودارهای تحلیلی در پنل مدیریت |
| **Font Awesome 6** | آیکون‌های گرافیکی |

---

## 📥 نصب و راه‌اندازی

### پیش‌نیازها

- **PHP** نسخه 8 یا بالاتر
- **MySQL** یا **MariaDB**
- **Apache** وب سرور با `mod_rewrite` فعال
- **XAMPP**، **WAMP**، **LAMP** و یا هر پکیج مشابه

### مراحل نصب

1. **دانلود پروژه**
   ```bash
   git clone https://github.com/mahdisavoji90/Project-College.git
   ```

2. **انتقال به هاست محلی**
   - محتویات پروژه را به پوشه `htdocs` (در XAMPP) یا `www` (در WAMP) منتقل کنید.
   - مسیر نهایی: `C:\xampp\htdocs\baziaft234\`

3. **ایجاد دیتابیس**
   - یک دیتابیس جدید با نام `baziaft` در MySQL ایجاد کنید.
   - فایل `baziaft.sql` را در دیتابیس ایجاد شده import کنید.

4. **تنظیمات دیتابیس**
   - فایل `config/database.php` را ویرایش کنید:
     ```php
     return [
         'host' => 'localhost',
         'dbname' => 'baziaft',
         'username' => 'root',
         'password' => '',
     ];
     ```
   - همچنین می‌توانید از فایل `.env.example` استفاده کنید.

5. **فعال کردن Rewrite Module در Apache**
   - در فایل `httpd.conf` اطمینان حاصل کنید که خط زیر فعال است:
     ```
     LoadModule rewrite_module modules/mod_rewrite.so
     ```
   - همچنین `AllowOverride All` برای پوشه پروژه تنظیم شده باشد.

6. **اجرا**
   - آدرس زیر را در مرورگر وارد کنید:
     ```
     http://localhost/baziaft234
     ```

---

## 📁 ساختار پروژه

```
baziaft234/
├── app/                      # هسته اصلی برنامه (MVC)
│   ├── Controllers/          # کنترلرها
│   │   └── AdminController.php
│   ├── Core/                 # کلاس‌های اصلی
│   │   ├── Database.php      # اتصال دیتابیس (Singleton PDO)
│   │   └── Router.php        # مسیریاب سفارشی
│   └── Models/               # مدل‌ها
├── config/                   # تنظیمات برنامه
│   └── database.php          # تنظیمات دیتابیس
├── image/                    # تصاویر عمومی سایت
├── public/                   # فایل‌های عمومی
├── routes/                   # مسیرهای برنامه
│   └── web.php               # تعریف تمام مسیرها
├── uploads/                  # فایل‌های آپلود شده
│   └── profiles/             # عکس‌های پروفایل
├── views/                    # صفحات نمایشی (ویوها)
│   ├── admin/                # صفحات پنل مدیریت
│   ├── uploads/              # آپلودهای ویو
│   ├── index.php             # صفحه اصلی
│   ├── dashboard.php         # داشبورد کاربری
│   ├── login.php             # صفحه ورود
│   ├── profile.php           # پروفایل کاربر
│   ├── header.php            # هدر سایت
│   ├── style.php             # استایل‌های CSS
│   └── script.php            # اسکریپت‌های JS
├── .htaccess                 # تنظیمات URL Rewriting
├── baziaft.sql               # دامپ دیتابیس
├── bootstrap.php             # بوت‌استرپ برنامه
├── index.php                 # فرانت کنترلر اصلی
└── router.php                # مسیریاب جایگزین
```

### جریان کار (Request Flow)

```
مرورگر → .htaccess (URL Rewriting) → index.php (Front Controller)
    → bootstrap.php (Session, DB, Helpers)
    → Router → routes/web.php → dispatch() → View
```

---

## 🧭 مسیریابی

تمامی مسیرهای برنامه در فایل `routes/web.php` تعریف شده‌اند:

### مسیرهای کاربری
| مسیر | توضیحات |
|------|---------|
| `/` | صفحه اصلی |
| `/login` | ورود کاربران |
| `/logout` | خروج کاربران |
| `/dashboard` | داشبورد کاربری |
| `/profile` | پروفایل کاربر |
| `/settings` | تنظیمات حساب |
| `/addresses` | مدیریت آدرس‌ها |
| `/requests` | درخواست‌های فروش |
| `/request` | جزئیات درخواست |
| `/transactions` | تراکنش‌ها |
| `/wallet` | کیف پول |
| `/rewards` | امتیازات و جوایز |
| `/notifications` | اعلان‌ها |

### مسیرهای مدیریت
| مسیر | توضیحات |
|------|---------|
| `/admin/login` | ورود مدیران |
| `/admin/logout` | خروج مدیران |
| `/admin` | داشبورد مدیریت |
| `/admin/users` | مدیریت کاربران |
| `/admin/recycling` | مدیریت ضایعات |
| `/admin/requests` | مدیریت درخواست‌ها |

---

## 👑 پنل مدیریت

پنل مدیریت دارای قابلیت‌های زیر است:

- **داشبورد تحلیلی**: نمایش آمار کاربران، درخواست‌ها و ضایعات با نمودار خطی ۷ روز اخیر (با Chart.js)
- **مدیریت کاربران**: مشاهده، جستجو، ویرایش و حذف کاربران
- **مدیریت ضایعات**: اضافه، ویرایش و حذف انواع ضایعات و قیمت‌گذاری
- **مدیریت درخواست‌ها**: مشاهده، تایید و رد درخواست‌های فروش کاربران

---

## 🗄️ دیتابیس

پروژه از دیتابیس MySQL با نام `baziaft` استفاده می‌کند.

### جداول اصلی

| جدول | توضیحات |
|------|---------|
| `users` | اطلاعات کاربران |
| `register_sell` | درخواست‌های فروش ضایعات |
| `recycling` | انواع ضایعات |
| `recycling_prices` | قیمت‌های ضایعات |
| `transactions` | تراکنش‌های مالی |
| `addresses` | آدرس‌های کاربران |
| `notifications` | اعلان‌ها |
| و... | سایر جداول مرتبط |

> فایل `baziaft.sql` شامل دامپ کامل دیتابیس با ساختار جداول و داده‌های اولیه است.

---

## 🔒 امنیت

- **رمز عبور**: ذخیره‌سازی با `password_hash()` (الگوریتم Bcrypt)
- **Session-based Authentication**: احراز هویت مبتنی بر سشن
- **توابع کمکی**: `require_user()` و `require_admin()` برای محافظت از مسیرهای خصوصی
- **SQL Injection Prevention**: استفاده از PDO و Prepared Statements
- **strict_types**: استفاده از `declare(strict_types=1)` در تمام فایل‌ها

---

## 🤝 مشارکت

از مشارکت شما در بهبود این پروژه استقبال می‌شود! برای مشارکت:

1. یک **Fork** از پروژه ایجاد کنید
2. یک **Branch** جدید برای ویژگی خود بسازید (`git checkout -b feature/AmazingFeature`)
3. تغییرات خود را **Commit** کنید (`git commit -m 'Add some AmazingFeature'`)
4. به **Push** کنید (`git push origin feature/AmazingFeature`)
5. یک **Pull Request** ثبت کنید

---

## 📄 لایسنس

این پروژه تحت لایسنس **MIT** منتشر شده است.

```
MIT License
Copyright (c) 2024 Mahdi Savoji
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files...
```

---

<p align="center">
  <b>بازیافت نوین</b> — ♻️ <i>به محیط زیست کمک کنیم</i>
</p>

---

# 🇬🇧 English

> **Online Scrap (Waste) Buying & Selling System (Electronics, Metals, Plastic, Paper)**  
> A web platform for managing waste sell requests with a complete admin panel

## 📋 Table of Contents

- [About The Project](#about-the-project)
- [Features](#features)
- [Built With](#built-with)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Routes](#routes)
- [Admin Panel](#admin-panel)
- [Database](#database)
- [Security](#security)
- [Contributing](#contributing)
- [License](#license)

---

## 🚀 About The Project

**Baziaft (Modern Recycling)** is an online scrap buying and selling website that allows users to:

- Register and create an account
- View up-to-date prices for various scrap types (electronics, metals, plastic, paper, etc.)
- Submit scrap sell requests
- Manage wallet and view transactions
- Earn points and rewards
- Manage addresses and personal profile
- Receive notifications

A powerful **Admin Panel** is also provided for system administrators to:

- Manage users
- Manage scrap types and prices
- Manage and approve sell requests
- View statistics and analytical charts

---

## ✨ Features

### 👤 User Section
- ✅ Secure registration & login with Bcrypt encryption
- ✅ Personal dashboard with account statistics
- ✅ User leveling system (Bronze, Silver, Gold, Diamond, VIP)
- ✅ Digital wallet & transaction management
- ✅ Points & rewards system
- ✅ Address management
- ✅ Scrap sell request submission
- ✅ Notifications panel
- ✅ Modern, responsive Dark Theme

### 🔐 Admin Section
- ✅ Admin dashboard with analytical charts (Chart.js)
- ✅ User management (search, edit, delete)
- ✅ Scrap type & pricing management
- ✅ Sell request review & approval
- ✅ Separate admin login system

---

## 🛠️ Built With

| Technology | Description |
|------------|-------------|
| **PHP 8+** | Server-side language with `declare(strict_types=1)` |
| **MySQL/MariaDB** | Relational database |
| **PDO** | Database connection with Singleton pattern |
| **Apache** | Web server with mod_rewrite |
| **HTML5 & CSS3** | Structure & styling with Dark Theme |
| **JavaScript (Vanilla)** | Client-side scripting |
| **Chart.js** | Charting library for admin analytics |
| **Font Awesome 6** | Graphic icons |

---

## 📥 Installation

### Prerequisites

- **PHP** 8 or higher
- **MySQL** or **MariaDB**
- **Apache** web server with `mod_rewrite` enabled
- **XAMPP**, **WAMP**, **LAMP** or similar package

### Setup Instructions

1. **Clone the project**
   ```bash
   git clone https://github.com/mahdisavoji90/Project-College.git
   ```

2. **Move to local server**
   - Copy the project contents to `htdocs` (XAMPP) or `www` (WAMP).
   - Final path: `C:\xampp\htdocs\baziaft234\`

3. **Create database**
   - Create a new database named `baziaft` in MySQL.
   - Import the `baziaft.sql` file into the created database.

4. **Database configuration**
   - Edit `config/database.php`:
     ```php
     return [
         'host' => 'localhost',
         'dbname' => 'baziaft',
         'username' => 'root',
         'password' => '',
     ];
     ```
   - You can also use the `.env.example` file.

5. **Enable Apache Rewrite Module**
   - In `httpd.conf`, make sure the following line is uncommented:
     ```
     LoadModule rewrite_module modules/mod_rewrite.so
     ```
   - Also ensure `AllowOverride All` is set for the project directory.

6. **Run**
   - Open your browser and navigate to:
     ```
     http://localhost/baziaft234
     ```

---

## 📁 Project Structure

```
baziaft234/
├── app/                      # Application core (MVC structure)
│   ├── Controllers/          # Controllers
│   │   └── AdminController.php
│   ├── Core/                 # Core classes
│   │   ├── Database.php      # Database connection (PDO Singleton)
│   │   └── Router.php        # Custom router
│   └── Models/               # Models (empty)
├── config/                   # Configuration files
│   └── database.php          # Database settings
├── image/                    # Public images
├── public/                   # Public files
├── routes/                   # Route definitions
│   └── web.php               # All application routes
├── uploads/                  # Uploaded files
│   └── profiles/             # User profile pictures
├── views/                    # Views (display pages)
│   ├── admin/                # Admin panel pages
│   ├── uploads/              # View-related uploads
│   ├── index.php             # Homepage
│   ├── dashboard.php         # User dashboard
│   ├── login.php             # Login page
│   ├── profile.php           # User profile
│   ├── header.php            # Site header
│   ├── style.php             # CSS styles
│   └── script.php            # JavaScript
├── .htaccess                 # URL Rewriting rules
├── baziaft.sql               # Database dump
├── bootstrap.php             # Application bootstrap
├── index.php                 # Front controller
└── router.php                # Alternative router
```

### Request Flow

```
Browser → .htaccess (URL Rewriting) → index.php (Front Controller)
    → bootstrap.php (Session, DB, Helpers)
    → Router → routes/web.php → dispatch() → View
```

---

## 🧭 Routes

All application routes are defined in `routes/web.php`:

### User Routes
| Route | Description |
|-------|-------------|
| `/` | Homepage |
| `/login` | User login |
| `/logout` | User logout |
| `/dashboard` | User dashboard |
| `/profile` | User profile |
| `/settings` | Account settings |
| `/addresses` | Address management |
| `/requests` | Sell requests |
| `/request` | Request details |
| `/transactions` | Transactions |
| `/wallet` | Wallet |
| `/rewards` | Points & rewards |
| `/notifications` | Notifications |

### Admin Routes
| Route | Description |
|-------|-------------|
| `/admin/login` | Admin login |
| `/admin/logout` | Admin logout |
| `/admin` | Admin dashboard |
| `/admin/users` | User management |
| `/admin/recycling` | Scrap management |
| `/admin/requests` | Request management |

---

## 👑 Admin Panel

The admin panel includes the following capabilities:

- **Analytical Dashboard**: Display user, request, and scrap statistics with a 7-day line chart (using Chart.js)
- **User Management**: View, search, edit, and delete users
- **Scrap Management**: Add, edit, and delete scrap types with pricing
- **Request Management**: View, approve, and reject user sell requests

---

## 🗄️ Database

The project uses a MySQL database named `baziaft`.

### Main Tables

| Table | Description |
|-------|-------------|
| `users` | User information |
| `register_sell` | Scrap sell requests |
| `recycling` | Scrap types |
| `recycling_prices` | Scrap prices |
| `transactions` | Financial transactions |
| `addresses` | User addresses |
| `notifications` | Notifications |
| etc. | Other related tables |

> The `baziaft.sql` file contains the complete database dump with table structures and initial data.

---

## 🔒 Security

- **Password**: Stored using `password_hash()` (Bcrypt algorithm)
- **Session-based Authentication**: Session-based authentication
- **Helper Functions**: `require_user()` and `require_admin()` to protect private routes
- **SQL Injection Prevention**: Using PDO and Prepared Statements
- **strict_types**: Using `declare(strict_types=1)` in all files

---

## 🤝 Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. **Fork** the project
2. Create your **Feature Branch** (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. Open a **Pull Request**

---

## 📄 License

Distributed under the **MIT License**.

```
MIT License
Copyright (c) 2024 Mahdi Savoji
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files...
```

---

## 👨‍💻 Developer

- **Mahdi Savoji** - Main Developer
- **GitHub**: [@mahdisavoji90](https://github.com/mahdisavoji90)

---

<p align="center">
  <b>بازیافت نوین (Baziaft)</b> — ♻️ <i>Let's help the environment</i>
</p>