<!-- game.php -->
<?php
session_start();

// دریافت اطلاعات از فرم (تنها در اولین بار)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['team_names'])) {
    $_SESSION['team_count'] = $_POST['team_count'];
    $_SESSION['team_names'] = $_POST['team_names'];
    $_SESSION['time_limit'] = $_POST['time_limit'];
    $_SESSION['rounds'] = $_POST['rounds'];
    $_SESSION['current_round'] = 1;
    $_SESSION['scores'] = array_fill(0, $_SESSION['team_count'], 0);
    $_SESSION['current_team'] = 0;
} else {
    // اگر اطلاعات فرم ارسال نشده است و جلسات تنظیم نشده‌اند، به صفحه اصلی برگردید
    if (!isset($_SESSION['team_names'])) {
        header('Location: index.php');
        exit();
    }
}

// بررسی اتمام بازی
if ($_SESSION['current_round'] > $_SESSION['rounds']) {
    header('Location: final.php');
    exit();
}

// مدیریت پایان بازی زودهنگام
if (isset($_POST['end_game'])) {
    header('Location: final.php?ended_early=1');
    exit();
}

// بارگذاری کلمات از فایل JSON
$wordsData = json_decode(file_get_contents('data/words.json'), true);
if ($wordsData === null) {
    die('خطا در تجزیه محتوای words.json. لطفاً از صحت ساختار JSON اطمینان حاصل کنید.');
}
if (!isset($wordsData['گروه‌ها'])) {
    die('کلید "گروه‌ها" در فایل words.json یافت نشد.');
}
$groups = $wordsData['گروه‌ها'];

// نمایش امتیازات تیم‌ها
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <!-- افزودن Meta Tag برای واکنش‌گرایی در موبایل -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازی ادا بازی - انتخاب گروه</title>
    
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>دور <?= $_SESSION['current_round']; ?> - نوبت تیم <?= htmlspecialchars($_SESSION['team_names'][$_SESSION['current_team']]); ?></h1>

<!-- نمایش امتیازات تیم‌ها -->
<div class="score-section">
    <h2>امتیازات فعلی:</h2>
    <table>
        <tr>
            <th>نام تیم</th>
            <th>امتیاز</th>
        </tr>
        <?php foreach ($_SESSION['team_names'] as $index => $name): ?>
        <tr>
            <td><?= htmlspecialchars($name); ?></td>
            <td><?= $_SESSION['scores'][$index]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- فرم انتخاب گروه و امتیاز -->
<div class="form-section">
    <form action="show_word.php" method="post" id="word-form">
        <label for="group">انتخاب گروه:</label>
        <select id="group" name="group">
            <?php foreach ($groups as $group): ?>
                <?php
                $groupName = htmlspecialchars($group['نام']);
                $displayName = ($group['نام'] == 'طلایی') ? 'طلایی (30 امتیازی)' : $groupName;
                ?>
                <option value="<?= $groupName; ?>"><?= htmlspecialchars($displayName); ?></option>
            <?php endforeach; ?>
        </select><br>

        <div id="points-container">
            <label for="points">امتیاز:</label>
            <select id="points" name="points">
                <option value="2">2 امتیازی</option>
                <option value="4">4 امتیازی</option>
                <option value="6">6 امتیازی</option>
                <!-- گزینه امتیاز ۳۰ را حذف می‌کنیم -->
            </select><br>
        </div>
		<br>

        <button type="submit" class="show-word-button">نمایش کلمه</button>
    </form>
</div>

<!-- افزودن اسکریپت جاوااسکریپت -->
<script src="js/game.js"></script>

<!-- دکمه پایان بازی را به پایین صفحه منتقل می‌کنیم -->
<!-- دکمه پایان بازی -->
<form action="" method="post">
    <button type="submit" name="end_game" class="end-game-button">پایان بازی و نمایش نتایج</button>
</form>

</body>
</html>
