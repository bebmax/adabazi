<!-- final.php -->
<?php
session_start();

// دریافت امتیازات نهایی
$teamNames = $_SESSION['team_names'];
$scores = $_SESSION['scores'];

// بررسی اتمام بازی زودهنگام
$endedEarly = isset($_GET['ended_early']) ? true : false;

// مرتب‌سازی تیم‌ها بر اساس امتیاز
$teamData = [];
foreach ($teamNames as $index => $name) {
    $teamData[] = ['name' => $name, 'score' => $scores[$index]];
}
usort($teamData, function($a, $b) {
    return $b['score'] - $a['score'];
});

// پاک کردن نشست برای شروع بازی جدید
session_destroy();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>نتایج نهایی بازی</title>
    
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
    <!-- افزودن Meta Tag برای واکنش‌گرایی در موبایل -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- لینک به فایل CSS (در صورت نیاز) -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php if ($endedEarly): ?>
    <h1>بازی زودتر به پایان رسید!</h1>
<?php else: ?>
    <h1>بازی به پایان رسید!</h1>
<?php endif; ?>

<h2>جدول امتیازات:</h2>

<table>
    <tr>
        <th>رتبه</th>
        <th>نام تیم</th>
        <th>امتیاز</th>
    </tr>
    <?php foreach ($teamData as $index => $team): ?>
        <tr>
            <td><?= $index + 1; ?></td>
            <td><?= htmlspecialchars($team['name']); ?></td>
            <td><?= $team['score']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<form action="index.php" method="get">
    <button type="submit">شروع بازی جدید</button>
</form>

</body>
</html>
