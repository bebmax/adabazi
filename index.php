<!-- index.php -->
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <!-- افزودن Meta Tag برای واکنش‌گرایی در موبایل -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازی ادا</title>
    
    <!-- جهت‌گیری راست به چپ برای زبان فارسی -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    
    <!-- تبدیل وب‌سایت به اپلیکیشن وب قابل نصب -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <!-- عنوان اپلیکیشن در صفحه‌ی اصلی -->
    <meta name="apple-mobile-web-app-title" content="ادا بازی">
    
    <!-- کنترل وضعیت نوار آدرس و نوار ابزار -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- آیکون اپلیکیشن برای صفحه‌ی اصلی -->
    <link rel="apple-touch-icon" href="icons/adabazi-icon-180x180.png">
    
    
    <!-- فایل‌های جاوااسکریپت شما -->
    <script src="js/game.js" defer></script>
	<script src="js/script.js" defer></script>
	
	
    <!-- لینک به فایل CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- استفاده از تگ‌های معنایی -->
<header class="main-header">
    <h1>ادا بازی</h1>
</header>

<main>
    <form action="game.php" method="post">
        <label for="team_count">تعداد تیم‌ها:</label>
        <input type="number" id="team_count" name="team_count" min="2" max="4" required><br>

        <!-- فیلدهای نام تیم‌ها با جاوااسکریپت ایجاد می‌شوند -->
        <div id="team-names-container">
            <!-- فیلدهای نام تیم‌ها در اینجا قرار می‌گیرند -->
        </div>

        <label for="time_limit">زمان حدس زدن:</label>
        <select id="time_limit" name="time_limit">
            <option value="60">1 دقیقه</option>
            <option value="90">1.5 دقیقه</option>
            <option value="120">2 دقیقه</option>
        </select><br>

        <label for="rounds">تعداد دورها:</label>
        <input type="number" id="rounds" name="rounds" min="1" max="10" required><br>

        <button type="submit">شروع بازی</button>
    </form>

    
</main>

<!-- لینک به فایل جاوااسکریپت -->
<script src="js/script.js"></script>
</body>
</html>
