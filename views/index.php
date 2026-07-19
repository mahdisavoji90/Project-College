<?php
require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . "/inc_db.php";
//      echo"<pre>";
                //    print_r($_SESSION);  
                //    echo "</pre>";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sss = "";
try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    $sss = "خطا در تنظیم attribute: ";
}

            $namenecessary = "";
            $passwordnecessary = "";
            $masage = "";
            $namenecessary = "";
            $passwordnecessary = "";
            $masage = "";
            
            $namenecessary = "";
            $passwordnecessary = "";
            $masage = "";
            
            if (isset($_POST['ssumbit'])) {
                // دریافت مقادیر
                $semail = trim($_POST['semail'] ?? '');
                $spassword = $_POST['spassword'] ?? '';
                $sconfirm = $_POST['regConfirm'] ?? '';
            
                // اعتبارسنجی
                if (empty($semail)) {
                    $namenecessary = "ایمیل اجباری است";
                } elseif (empty($spassword)) {
                    $passwordnecessary = "رمز عبور اجباری است";
                } elseif ($spassword !== $sconfirm) {
                    $passwordnecessary = "رمز عبور و تکرار آن یکسان نیستند";
                } else {
                    // همه چیز اوکی است، اقدام به درج
                    try {
                        // (اختیاری) بررسی تکراری نبودن ایمیل
                        $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ?");
                        $checkStmt->execute([$semail]);
                        if ($checkStmt->fetch()) {
                            $masage = "این ایمیل قبلاً ثبت شده است";
                        } else {
                            $hashed = password_hash($spassword, PASSWORD_DEFAULT);
                            $insertStmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                            $success = $insertStmt->execute(['email' => $semail, 'password' => $hashed]);
                            if ($success) {
                                $masage = "ثبت نام با موفقیت انجام شد";
                            } else {
                                $masage = "خطای ناشناخته در درج اطلاعات";
                            }
                        }
                    } catch (PDOException $e) {
                        // نمایش خطای واقعی دیتابیس
                        $masage = "خطای دیتابیس: " . $e->getMessage();
                    }
                }
            }
            $loginError = "";
            
            if (isset($_POST['submit'])) {
                $email = trim($_POST['email'] ?? '');
                $passwordd = $_POST['password'] ?? '';
            
                if (empty($email) || empty($passwordd)) {
                    $loginError = "همه فیلدها الزامی است";
                } else {
                    // کوئری آماده برای جلوگیری از SQL injection
                    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
                    if ($user && password_verify($passwordd, $user['password'])) {
                        // لاگین موفق
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_email'] = $user['email'];
                        // ریدایرکت به صفحه اصلی یا پنل کاربری
                    } else {
                        $loginError = "ایمیل یا رمز عبور اشتباه است";
                    }
                }
            }


?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازیافت نوین | تم تیره | خرید ضایعات الکترونیک و فلزات</title>
   <?php require_once(BASE_PATH . "/views/style.php"); ?>
</head>
<body>

<header class="site-header">
   <?php 
   include(BASE_PATH . "/views/header.php");
   ?>
</header>

<main class="container">
    <!-- صفحه اصلی (خانه) -->
    <div id="homeView" class="view active-view">
        <div class="slider-container">
            <div class="slider" id="slider"></div>
            <button class="slider-btn prev" id="prevSlide">‹</button>
            <button class="slider-btn next" id="nextSlide">›</button>
        </div>

        <h2 class="section-title">📋 لیست قیمت ضایعات (تومان به ازای هر کیلوگرم)</h2>
        <div class="price-list-modern" id="priceListContainer">
        </div>

        <!-- بخش فرم درخواست فروش (فقط پس از لاگین) -->
        <div id="scrapRequestSection" name="scrapRequestSection" style="<?= isset($_SESSION['user_id']) ? 'display: block;' : 'display: none;' ?>">
            <div class="request-card">
                <h3 style="margin-bottom: 20px; color:#cbd5e6;">📝 ثبت درخواست فروش ضایعات</h3>
                <div id="requestSuccessMsg" class="success-msg" style="display: none;"></div>
<!--اینجا بودم-->
                <form name="scrapForm" id="scrapForm" method="POST" action="">
                    <div class="form-group">
                        <label>نوع ضایعات</label>
                        <?php
                        $registers = $db->prepare("SELECT recyclingtype ,id FROM recycling ");
                        $registers->execute();
                        $registerss = $registers->fetchall(PDO::FETCH_ASSOC);
                        ?>
                        <select id="scrapType" name="selecttype" required>
                            <option value="">انتخاب کنید</option>
                            <?php foreach($registerss as $register ) : ?>
                            
                                <option value="<?= $register['id'] ?>">
                                    <?= htmlspecialchars($register['recyclingtype']) ?>
                                </option>


                                <?php endforeach ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label>وزن (کیلوگرم)</label>
                        <input name="weight" type="number" id="weight" step="0.1" required>
                    </div>
                    <div class="form-group">
                        <label>توضیحات (نوع دقیق، بسته‌بندی و ...)</label>
                        <textarea name="desc" id="desc" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>تلفن تماس</label>
                        <input type="tel" name="phone" >
                    </div>
                        <?php
                        if(isset($_POST['submitsell'])){
                        try {
                            $selecttype = $_POST['selecttype'] ?? null;
                            $weight = isset($_POST['weight']) ? (float)$_POST['weight'] : null;
                            $description = trim($_POST['desc'] ?? '');
                            $phone = trim($_POST['phone'] ?? '');
                            
                            // 1. اعتبارسنجی شماره موبایل
                            if (!empty($phone) && (strlen($phone) != 11 || !ctype_digit($phone))) {
                                $masage = "شماره موبایل باید دقیقا 11 رقم عددی باشد";
                            }
                            // 2. بررسی پر بودن فیلدهای اجباری
                            elseif ($selecttype === null || $weight === null || $weight <= 0 || empty($phone)) {
                                $masage = "لطفا تمام فیلدها را پر کنید.";
                            }
                            // 3. بررسی لاگین بودن کاربر
                            elseif (!isset($_SESSION['user_id'])) {
                                $masage = "لطفا ابتدا وارد شوید.";
                            }
                            // 4. درج در دیتابیس
                            else {
                                $stmt = $db->prepare("INSERT INTO register_sell (users_id, recyclingtype_id, weight, description, numberphone) VALUES (?, ?, ?, ?, ?)");
                                $result = $stmt->execute([$_SESSION['user_id'], $selecttype, $weight, $description, $phone]);
                                $masage = $result ? "با موفقیت ارسال شد" : "با خطا مواجه شد";
                            }
                        } catch(PDOException $e) {
                            $masage = "خطای پایگاه داده: " . $e->getMessage();
                        }
                    }

                    ?>


                    <button name="submitsell" type="submit" class="btn btn-primary">ثبت درخواست فروش</button>
                </form>
                
                <div id="prevRequestsContainer" class="prev-requests-list">
                    <h4 style="color:#cbd5e6;">📦 درخواست‌های قبلی شما</h4>
                    <h4 style="color:#cbd5e6;"><?= htmlspecialchars($masage) ?></h4>
                    <div id="prevRequestsList"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- صفحه جزئیات (اسلایدر) -->
    <div id="detailView" class="view" >
        <div class="detail-card" id="detailContent" ></div>
        <button class="btn btn-outline back-home" id="backHomeBtn">← بازگشت به صفحه اصلی</button>
    </div>

    <!-- صفحه ورود / ثبت‌نام -->
    <?php
            

    ?>

    <div id="loginRegisterView" class="view">
        <div class="login-card">
            <div class="tabs">
                <button class="tab-btn active" id="showLoginTab">ورود</button>
                <button class="tab-btn" id="showRegisterTab">ثبت‌نام</button>
            </div>
            <div id="loginFormContainer">
                <form action="" id="loginForm" method="POST">
                    <div> <?= $masage ?> <?= $loginError ?><?= $sss ?> </div>
                    <div class="form-group">
                        <label>ایمیل</label>
                        <input name="email" type="email" id="loginEmail" required>
                    </div>
                    <div class="form-group">
                        <label>رمز عبور</label>
                        <input name="password" type="password" id="loginPassword" required>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary" style="width:100%">ورود</button>
                    <div id="loginError" style="color:#f87171; margin-top:12px;"></div>
                </form>
            </div>
            
            <div id="registerFormContainer" style="display:none;">
           

              <form action="" id="registerForm" method="POST">
                    <div class="form-group">
                        <label>ایمیل</label>
                        <input name="semail" type="email" id="regEmail" required>
                        <div> <?= $namenecessary ?></div>
                    </div>
                    <div class="form-group">
                        <label>رمز عبور</label>
                        <input name="spassword" type="password" id="regPassword" required>
                        <div><?= $passwordnecessary ?></div>
                    </div>
                    <div class="form-group">
                        <label>تکرار رمز عبور</label>
                        <input name="regConfirm" type="password" id="regConfirm" required>
                    </div>
                    <button name="ssumbit" type="submit" class="btn btn-primary" style="width:100%">ثبت‌نام</button>
                    <div id="regError" style="color:#f87171; margin-top:12px;"></div>
                </form>
            </div>
        </div>
    </div>
</main>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فوتر تیره</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- محتوای اصلی برای تست -->
    <main style="flex:1; padding:40px 20px; text-align:center;">
        <h1 style="color:#e0e0e0;">محتوای اصلی صفحه</h1>
        <p style="color:#666; margin-top:10px;">برای دیدن فوتر تیره به پایین اسکرول کنید</p>
    </main>

    <!-- ========================================== -->
    <!-- ================ FOOTER ================== -->
    <!-- ========================================== -->
    <footer>
        <div class="container">

            <!-- گرید اصلی فوتر -->
            <div class="footer-grid">

                <!-- ستون اول: درباره ما -->
                <div class="footer-about">
                    <h3>
                        <i class="fas fa-recycle"></i>
                        بازیافت نوین
                    </h3>
                    <p>
                        بزرگترین پلتفرم خرید و فروش آنلاین ضایعات در ایران. 
                        با ما به آینده‌ای سبزتر و پایدارتر کمک کنید. 
                        قیمت‌های روز، کیفیت تضمینی و خدمات سریع.
                    </p>
                    <div class="footer-social">
                        <a href="#" aria-label="تلگرام"><i class="fab fa-telegram-plane"></i></a>
                        <a href="#" aria-label="اینستاگرام"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="واتساپ"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" aria-label="لینکدین"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="آپارات"><i class="fas fa-play-circle"></i></a>
                    </div>
                </div>

                <!-- ستون دوم: لینک‌های مفید -->
                <div class="footer-col">
                    <h4>لینک‌های مفید</h4>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> قیمت روز ضایعات</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> راهنمای خرید</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> راهنمای فروش</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> سوالات متداول</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> بلاگ و اخبار</a></li>
                    </ul>
                </div>

                <!-- ستون سوم: دسته‌بندی -->
                <div class="footer-col">
                    <h4>دسته‌بندی‌ها</h4>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> آهن و فولاد</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> آلومینیوم</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> مس و برنج</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> پلاستیک و نایلون</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> کاغذ و مقوا</a></li>
                    </ul>
                </div>

                <!-- ستون چهارم: تماس با ما -->
                <div class="footer-col footer-contact">
                    <h4>تماس با ما</h4>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            تهران، خیابان آزادی، نبش خیابان ۲۰، پلاک ۱۲
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            ۰۲۱-۱۲۳۴-۵۶۷۸
                        </li>
                        <li>
                            <i class="fas fa-mobile-alt"></i>
                            ۰۹۱۲-۳۴۵-۶۷۸۹
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            info@novinrecycle.com
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            شنبه تا چهارشنبه ۹ الی ۱۸
                        </li>
                    </ul>
                </div>

            </div>
            <!-- پایان گرید -->

            <!-- لینک‌های پایین -->
            <div class="footer-links">
                <a href="#">درباره ما</a>
                <span class="separator">|</span>
                <a href="#">تماس با ما</a>
                <span class="separator">|</span>
                <a href="#">حریم خصوصی</a>
                <span class="separator">|</span>
                <a href="#">قوانین بازیافت</a>
                <span class="separator">|</span>
                <a href="#">پشتیبانی آنلاین</a>
            </div>

            <!-- کپی‌رایت -->
            <div class="copyright">
                <i class="fas fa-heart"></i>
                © ۱۴۰۴ - <span>بازیافت نوین</span> | تمامی حقوق محفوظ است
                <br>
                <small>تم تیره | خرید و فروش آنلاین ضایعات با قیمت روز</small>
            </div>

        </div>
    </footer>

    <!-- دکمه اسکرول به بالا -->
    <button class="scroll-top" id="scrollTopBtn" aria-label="بازگشت به بالا">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- ====== اسکریپت ====== -->
    <script>
        const scrollBtn = document.getElementById('scrollTopBtn');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        });

        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

</body>
</html>
<?php 

include(BASE_PATH . "/views/script.php");

?>

</body>
</html>