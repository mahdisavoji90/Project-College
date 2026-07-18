<script >
    document.querySelectorAll('.menu-item[data-page]').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        window.location.href = page;
    });
});

    // ========== کنترل منوی سایدبار ==========
const sidebarToggle = document.getElementById('sidebarToggle');
const profileSidebar = document.getElementById('profileSidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const sidebarLogout = document.getElementById('sidebarLogout');

// باز/بسته کردن منو
function toggleSidebar() {
    sidebarToggle.classList.toggle('active');
    profileSidebar.classList.toggle('active');
    sidebarOverlay.classList.toggle('active');
    document.body.style.overflow = profileSidebar.classList.contains('active') ? 'hidden' : '';
}

sidebarToggle?.addEventListener('click', toggleSidebar);
sidebarOverlay?.addEventListener('click', toggleSidebar);

// بستن منو با ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && profileSidebar.classList.contains('active')) {
        toggleSidebar();
    }
});

// فعال/غیرفعال کردن آیتم‌های منو
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        
        const page = item.dataset.page;
        console.log('صفحه انتخاب شده:', page);
        // اینجا می‌تونی محتوای صفحه رو لود کنی
    });
});

// خروج از حساب
sidebarLogout?.addEventListener('click', () => {
    if (confirm('آیا مطمئن هستید که می‌خواهید خارج شوید؟')) {
        window.location.href = 'logout.php'; // یا هر مسیری که برای logout داری
    }
});

    
    let currentUser = <?= isset($_SESSION['user_id']) ? json_encode($_SESSION['user_email']) : 'null' ?>;
    let isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
    function logoutUser() {
    // فقط برای هماهنگی با دکمه خروج در هدر (اگر با AJAX می‌خواهید)
    window.location.href = "logout.php";
}
document.getElementById("logoutBtn")?.addEventListener("click", logoutUser);
    // ---------- ذخیره‌سازی محلی ----------
    // if (!localStorage.getItem("users")) localStorage.setItem("users", JSON.stringify([]));
    // if (!localStorage.getItem("scrapRequests")) localStorage.setItem("scrapRequests", JSON.stringify({}));
    // let currentUser = localStorage.getItem("currentUser") || null;

    // ---------- لیست قیمت به تومان ----------
    
    const priceItems = [
        { name: "مس (Copper)", pricePerKg: "۷۵۰,۰۰۰" },
        { name: "آلومینیوم (Aluminum)", pricePerKg: "۲۱۰,۰۰۰" },
        { name: "مادربورد (Motherboard)", pricePerKg: "۴۸۰,۰۰۰" },
        { name: "رم (RAM)", pricePerKg: "۳۲۰,۰۰۰" },
        { name: "پردازنده (CPU)", pricePerKg: "۲,۸۰۰,۰۰۰" },
        { name: "فولاد (Steel)", pricePerKg: "۳۵,۰۰۰" },
        { name: "باتری یو پی اس", pricePerKg: "۹۰,۰۰۰" }
    ];

    // ---------- اسلایدر با ۳ تصویر و توضیحات ----------
    const slides = [
        { img: "/baziaft234/image/20469524-cf17-4590-b7de-a7808fa6f07c.png", title: "بازیافت قطعات الکترونیک", desc: "کامپیوترهای فرسوده، بردهای مدار چاپی و سیم‌های مسی قابل بازیافت هستند. فلزات گرانبها مانند طلا، نقره و پالادیوم استخراج می‌شوند و مواد سمی به صورت ایمن دفع می‌گردند. بازیافت هر یک میلیون موبایل حدود ۱۶ تن مس، ۳۵۰ کیلوگرم نقره و ۳۴ کیلوگرم طلا تولید می‌کند." },
        { img: "/baziaft234/image/f1c26400-404c-4a14-a23f-6e0d38e54b36.png", title: "بازیافت فلزات (آهن، مس، آلومینیوم)", desc: "فلزات ضایعاتی بدون افت کیفیت قابل ذوب مجدد هستند. بازیافت آلومینیوم ۹۵٪ انرژی کمتری نسبت به تولید اولیه نیاز دارد. ما فلزات آهنی و غیرآهنی را با بالاترین نرخ خریداری می‌کنیم." },
        { img: "/baziaft234/image/35df0065-7d0d-413a-890c-dd7abdef3b00.png", title: "پلاستیک‌های صنعتی و نخاله‌ها", desc: "پلاستیک‌های PP، PE، PVC و پت پس از خردایش و شستشو به گرانول تبدیل می‌شوند. این مواد در ساخت قطعات خودرو، لوله و مبلمان شهری کاربرد دارند. با ما در کاهش آلودگی پلاستیک همکاری کنید." }
    ];

    // DOM elements
    const homeView = document.getElementById("homeView");
    const detailView = document.getElementById("detailView");
    const loginRegView = document.getElementById("loginRegisterView");
    const authDiv = document.getElementById("authButtonsArea");
    const welcomeDiv = document.getElementById("userWelcomeArea");
    const welcomeMsgSpan = document.getElementById("welcomeMsg");
    const scrapSection = document.getElementById("scrapRequestSection");
    const sliderDiv = document.getElementById("slider");
    const priceContainer = document.getElementById("priceListContainer");
    const backHome = document.getElementById("backHomeBtn");
    const detailContent = document.getElementById("detailContent");

    let currentSlide = 0;

    function showView(viewId) {
        homeView.classList.remove("active-view");
        detailView.classList.remove("active-view");
        loginRegView.classList.remove("active-view");
        if (viewId === "home") homeView.classList.add("active-view");
        else if (viewId === "detail") detailView.classList.add("active-view");
        else if (viewId === "loginRegister") loginRegView.classList.add("active-view");
    }

    // رندر لیست قیمت
    function renderPriceList() {
        priceContainer.innerHTML = "";
        priceItems.forEach(item => {
            const div = document.createElement("div");
            div.className = "price-item";
            div.innerHTML = `
                <span class="item-name">${item.name}</span>
                <span class="item-price">${item.pricePerKg} تومان / کیلو</span>
            `;
            priceContainer.appendChild(div);
        });
    }

    // رندر اسلایدر
    function renderSlider() {
        sliderDiv.innerHTML = "";
        slides.forEach((slide, idx) => {
            const slideEl = document.createElement("div");
            slideEl.className = "slide";
            slideEl.setAttribute("data-idx", idx);
            const img = document.createElement("img");
            img.src = slide.img;
            img.alt = slide.title;
            slideEl.appendChild(img);
            slideEl.addEventListener("click", () => openDetail(idx));
            sliderDiv.appendChild(slideEl);
        });
        updateSliderPosition();
    }

    function updateSliderPosition() {
        sliderDiv.style.transform = `translateX(${currentSlide * 100}%)`;
    }
    function nextSlide() { currentSlide = (currentSlide + 1) % slides.length; updateSliderPosition(); }
    function prevSlide() { currentSlide = (currentSlide - 1 + slides.length) % slides.length; updateSliderPosition(); }

    function openDetail(idx) {
        const s = slides[idx];
        detailContent.innerHTML = `
            <h2 style="color:#2dd4bf;">♻️ ${s.title}</h2>
            <hr>
            <p style="line-height:1.7; margin-top:16px;">${s.desc}</p>
            <div style="margin-top:24px; background:#0f172a; padding:14px; border-radius:20px; border-right: 3px solid #10b981;">
                <small>✅ فرآیند بازیافت تخصصی | کاهش پسماند و حفظ منابع</small>
            </div>
        `;
        showView("detail");
    }

    // ---------- احراز هویت ----------
    function registerUser(email, pass, confirm) {
        if (pass !== confirm) throw new Error("رمز عبور و تکرار آن مطابقت ندارند");
        let users = JSON.parse(localStorage.getItem("users"));
        if (users.find(u => u.email === email)) throw new Error("این ایمیل قبلاً ثبت شده است");
        users.push({ email, password: pass });
        localStorage.setItem("users", JSON.stringify(users));
        return true;
    }
    function loginUser(email, pass) {
        let users = JSON.parse(localStorage.getItem("users"));
        const user = users.find(u => u.email === email && u.password === pass);
        if (!user) throw new Error("ایمیل یا رمز نادرست است");
        currentUser = email;
        localStorage.setItem("currentUser", email);
        updateUIByAuth();
        showView("home");
    }
    // function logoutUser() {
    //     currentUser = null;
    //     localStorage.removeItem("currentUser");
    //     updateUIByAuth();
    //     showView("home");
    // }

    // بارگذاری درخواست‌های قبلی
    function loadUserRequests() {
        if (!currentUser) return;
        const allRequests = JSON.parse(localStorage.getItem("scrapRequests")) || {};
        const userReqs = allRequests[currentUser] || [];
        const container = document.getElementById("prevRequestsList");
        if (!container) return;
        if (userReqs.length === 0) {
            container.innerHTML = "<p style='color:#94a3b8;'>هیچ درخواستی ثبت نکرده‌اید.</p>";
            return;
        }
        container.innerHTML = userReqs.map(req => `
            <div class="request-item">
                <strong style="color:#a7f3d0;">${req.type}</strong> — وزن: ${req.weight} کیلوگرم 
                <span style="display:block; font-size:0.8rem; margin-top:6px;">📞 ${req.phone || 'بدون شماره'} | توضیحات: ${req.description || '-'}</span>
            </div>
        `).join("");
    }

    // ثبت درخواست فروش
    function submitScrap(e) {
        e.preventDefault();
        if (!currentUser) return alert("لطفاً وارد شوید");
        const type = document.getElementById("scrapType").value;
        const weight = document.getElementById("weight").value;
        const desc = document.getElementById("desc").value;
        const phone = document.getElementById("phone").value;
        if (!type || !weight) {
            alert("لطفاً نوع ضایعات و وزن را وارد کنید");
            return;
        }
        const newReq = {
            type, weight, description: desc, phone, date: new Date().toLocaleString("fa-IR")
        };
        const allReqs = JSON.parse(localStorage.getItem("scrapRequests"));
        if (!allReqs[currentUser]) allReqs[currentUser] = [];
        allReqs[currentUser].push(newReq);
        localStorage.setItem("scrapRequests", JSON.stringify(allReqs));
        const msgDiv = document.getElementById("requestSuccessMsg");
        msgDiv.style.display = "block";
        msgDiv.innerHTML = "✅ درخواست فروش شما با موفقیت ثبت شد. کارشناسان ما تماس می‌گیرند.";
        setTimeout(() => msgDiv.style.display = "none", 3500);
        //document.getElementById("scrapForm").reset();
        loadUserRequests();
    }

    // به‌روزرسانی UI بر اساس وضعیت ورود
    function updateUIByAuth() {
        if (currentUser) {
            authDiv.style.display = "none";
            welcomeDiv.style.display = "flex";
            welcomeMsgSpan.innerHTML = `خوش آمدید، ${currentUser}`;
            scrapSection.style.display = "block";
            loadUserRequests();
        } else {
            authDiv.style.display = "flex";
            welcomeDiv.style.display = "none";
            scrapSection.style.display = "none";
        }
    }

    // رویدادهای دکمه‌ها با بررسی وجود المان
const loginBtn = document.getElementById("loginNavBtn");
if (loginBtn) loginBtn.onclick = () => showView("loginRegister");

const registerBtn = document.getElementById("registerNavBtn");
if (registerBtn) registerBtn.onclick = () => {
    showView("loginRegister");
    const regTab = document.getElementById("showRegisterTab");
    if (regTab) regTab.click();
};

const backHomeBtn = document.getElementById("backHomeBtn");
if (backHomeBtn) backHomeBtn.onclick = () => showView("home");

const prevSlideBtn = document.getElementById("prevSlide");
if (prevSlideBtn) prevSlideBtn.onclick = prevSlide;

const nextSlideBtn = document.getElementById("nextSlide");
if (nextSlideBtn) nextSlideBtn.onclick = nextSlide;

// const scrapFormElem = document.getElementById("scrapForm");
// if (scrapFormElem) scrapFormElem.addEventListener("submit", submitScrap);

// تب‌های ورود/ثبت‌نام
const loginTab = document.getElementById("showLoginTab");
const regTabBtn = document.getElementById("showRegisterTab");
const loginContainer = document.getElementById("loginFormContainer");
const registerContainer = document.getElementById("registerFormContainer");

if (loginTab && regTabBtn && loginContainer && registerContainer) {
    loginTab.onclick = () => {
        loginTab.classList.add("active");
        regTabBtn.classList.remove("active");
        loginContainer.style.display = "block";
        registerContainer.style.display = "none";
    };
    regTabBtn.onclick = () => {
        regTabBtn.classList.add("active");
        loginTab.classList.remove("active");
        loginContainer.style.display = "none";
        registerContainer.style.display = "block";
    };
}
    // document.getElementById("loginForm").addEventListener("submit", (e) => {
    //     e.preventDefault();
    //     const email = document.getElementById("loginEmail").value;
    //     const pass = document.getElementById("loginPassword").value;
    //     try { loginUser(email, pass); document.getElementById("loginError").innerText = ""; }
    //     catch(err) { document.getElementById("loginError").innerText = err.message; }
    // });
    // document.getElementById("registerForm").addEventListener("submit", (e) => {
    //     e.preventDefault();
    //     const email = document.getElementById("regEmail").value;
    //     const pass = document.getElementById("regPassword").value;
    //     const conf = document.getElementById("regConfirm").value;
    //     try { registerUser(email, pass, conf); alert("ثبت‌نام موفق! اکنون وارد شوید."); loginTab.click(); document.getElementById("regError").innerText = ""; }
    //     catch(err) { document.getElementById("regError").innerText = err.message; }
    // });

    // مقداردهی اولیه
    renderPriceList();
    renderSlider();
    updateUIByAuth();
    showView("home");
    sliderDiv.style.display = "flex";
    sliderDiv.style.transition = "transform 0.3s ease";
</script>