<?php


require_once "includes/db.php";;   // loads getDB() — MySQL connection

$success = '';
$error   = '';

// Run only when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get and clean form fields
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $phone   = trim($_POST['phone']   ?? '');
  $service = trim($_POST['service'] ?? '');
  $message = trim($_POST['message'] ?? '');

  // Validate required fields
  if (empty($name) || empty($email) || empty($message)) {
    $error = 'يرجى ملء جميع الحقول المطلوبة.';

  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'البريد الإلكتروني غير صحيح.';

  } else {
    try {
      $db = getDB();   // connect to MySQL

      // Create the table if it doesn't exist
      $db->exec("
        CREATE TABLE IF NOT EXISTS contact_messages (
          id         INT AUTO_INCREMENT PRIMARY KEY,
          name       VARCHAR(255) NOT NULL,
          email      VARCHAR(255) NOT NULL,
          phone      VARCHAR(50),
          service    VARCHAR(255),
          message    TEXT NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
      ");

      // Insert the message using a prepared statement (safe from SQL injection)
      $stmt = $db->prepare("
        INSERT INTO contact_messages (name, email, phone, service, message)
        VALUES (?, ?, ?, ?, ?)
      ");
      $stmt->execute([$name, $email, $phone, $service, $message]);

      $success = 'تم إرسال رسالتك بنجاح! سنتواصل معك خلال 24 ساعة.';

    } catch (Exception $e) {
      $error = 'حدث خطأ في قاعدة البيانات، يرجى المحاولة لاحقاً.';
      error_log($e->getMessage());
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تواصل معنا — وكالة النجوم</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="container">
   <a href="index.html" class="logo">
         <img src="favicon.svg" alt="logo" width="32" height="32">
          <span>وكالة سبيس</span>
      </a>
      <div class="nav-links">
        <a href="index.php">الرئيسية</a>
        <a href="services.php">الخدمات</a>
        <a href="pricing.html">الأسعار</a>
        <a href="contact.php" class="active">تواصل معنا</a>
      </div>

      <div class="nav-actions">
        <a href="contact.php" class="btn btn-solid" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">ابدأ مجاناً</a>
      </div>

      <button class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </button>
    </div>

    <div class="mobile-menu" id="mobile-menu">
      <a href="index.php">الرئيسية</a>
      <a href="services.php">الخدمات</a>
      <a href="pricing.html">الأسعار</a>
      <a href="contact.php">تواصل معنا</a>
    </div>
  </nav>

  <!-- ===== PAGE HERO ===== -->
  <section class="page-hero">
    <div class="container">
      <div class="breadcrumb">
        <a href="index.php">الرئيسية</a>
        <span class="breadcrumb-sep">›</span>
        <span>تواصل معنا</span>
      </div>
      <span class="section-label">تواصل معنا</span>
      <h1 class="section-title">نحن هنا <span>لمساعدتك</span></h1>
      <p class="section-desc" style="margin: 0 auto;">هل لديك سؤال؟ أرسل لنا رسالة وسيرد فريقنا خلال 24 ساعة.</p>
    </div>
  </section>

  <!-- ===== CONTACT SECTION ===== -->
  <section class="section">
    <div class="container">
      <div class="contact-grid">

        <!-- LEFT: Contact Info -->
        <div class="contact-info">
          <h2>معلومات التواصل</h2>
          <p>فريقنا متاح من الأحد إلى الخميس خلال ساعات العمل للإجابة على جميع استفساراتك.</p>

          <div class="contact-detail">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span>hello@alnujoom.agency</span>
          </div>

          <div class="contact-detail">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.81a16 16 0 0 0 6.29 6.29l.95-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span dir="ltr">+966 50 000 0000</span>
          </div>

          <div class="contact-detail">
            <svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>الرياض، المملكة العربية السعودية</span>
          </div>

          <div class="contact-detail">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>الأحد – الخميس: 9 صباحاً – 6 مساءً</span>
          </div>
        </div>

        <!-- RIGHT: Contact Form -->
        <div class="form-box">
          <h3>أرسل رسالتك</h3>
          <p class="sub">سنرد عليك خلال 24 ساعة كحد أقصى.</p>

          <!-- Success / Error message -->
          <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
          <?php endif; ?>

          <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <!-- Form submits to the same page via POST -->
          <form method="POST" action="contact.php">

            <div class="form-row">
              <div class="form-group">
                <label>الاسم الكامل *</label>
                <input type="text" name="name" placeholder="محمد العمري" required>
              </div>
              <div class="form-group">
                <label>البريد الإلكتروني *</label>
                <input type="email" name="email" placeholder="example@email.com" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="tel" name="phone" placeholder="+966 50 000 0000" dir="ltr">
              </div>
              <div class="form-group">
                <label>الخدمة المطلوبة</label>
                <select name="service">
                  <option value="">— اختر الخدمة —</option>
                  <option value="SEO">تحسين محركات البحث</option>
                  <option value="Ads">الإعلانات المدفوعة</option>
                  <option value="Social">إدارة السوشيال ميديا</option>
                  <option value="Content">إنشاء المحتوى</option>
                  <option value="Email">التسويق بالبريد</option>
                  <option value="Other">أخرى</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>رسالتك *</label>
              <textarea name="message" placeholder="اكتب رسالتك هنا..." required></textarea>
            </div>

            <button type="submit" class="btn btn-solid" style="width: 100%;">إرسال الرسالة</button>

          </form>
        </div>

      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">

        <div>
   <a href="index.html" class="logo">
         <img src="favicon.svg" alt="logo" width="32" height="32">
          <span>وكالة سبيس</span>
      </a>          
      <p class="footer-desc">نقدم خدمات التسويق الرقمي الاحترافية لمساعدة أعمالك على النمو وتحقيق أهدافها.</p>
        </div>

        <div class="footer-col">
          <h4>الصفحات</h4>
          <a href="index.php">الرئيسية</a>
          <a href="services.php">الخدمات</a>
          <a href="pricing.html">الأسعار</a>
          <a href="contact.php">تواصل معنا</a>
        </div>

        <div class="footer-col">
          <h4>تواصل معنا</h4>
          <a href="mailto:hello@alnujoom.agency">hello@alnujoom.agency</a>
          <span>+966 50 000 0000</span>
          <span>الرياض، المملكة العربية السعودية</span>
        </div>

      </div>
      <div class="footer-bottom">© <?= date('Y') ?> وكالة النجوم — جميع الحقوق محفوظة</div>
    </div>
  </footer>

  <script src="js/script.js"></script>
</body>
</html>
