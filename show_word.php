<!-- show_word.php -->
<?php
session_start();

// بررسی اتمام بازی
if (isset($_POST['end_game'])) {
    header('Location: final.php?ended_early=1');
    exit();
}

// دریافت گروه و امتیاز انتخاب شده
$selectedGroupName = $_POST['group'];

// دریافت امتیاز انتخاب شده
if (!isset($_POST['points'])) {
    echo "<script>alert('امتیاز انتخاب شده نامعتبر است.'); window.history.back();</script>";
    exit();
}
$selectedPoints = intval($_POST['points']);

// بارگذاری کلمات
$wordsData = json_decode(file_get_contents('data/words.json'), true);
if ($wordsData === null) {
    die('خطا در تجزیه محتوای words.json. لطفاً از صحت ساختار JSON اطمینان حاصل کنید.');
}
if (!isset($wordsData['گروه‌ها'])) {
    die('کلید "گروه‌ها" در فایل words.json یافت نشد.');
}
$groups = $wordsData['گروه‌ها'];

// پیدا کردن گروه انتخاب شده
$selectedGroup = null;
foreach ($groups as $group) {
    if ($group['نام'] == $selectedGroupName) {
        $selectedGroup = $group;
        break;
    }
}

if (!$selectedGroup) {
    die('گروه انتخاب شده یافت نشد.');
}

// بررسی سازگاری امتیاز و گروه
if ($selectedGroupName === 'طلایی') {
    if ($selectedPoints != 30) {
        echo "<script>alert('برای گروه طلایی، امتیاز باید ۳۰ باشد.'); window.history.back();</script>";
        exit();
    }
} else {
    if ($selectedPoints == 30) {
        echo "<script>alert('امتیاز ۳۰ فقط برای گروه طلایی قابل انتخاب است.'); window.history.back();</script>";
        exit();
    }
}

// فیلتر کردن کلمات بر اساس امتیاز
$filteredWords = array_filter($selectedGroup['کلمات'], function($word) use ($selectedPoints) {
    return $word['امتیاز'] == $selectedPoints;
});

// بررسی وجود کلمات با امتیاز مورد نظر
if (empty($filteredWords)) {
    echo "<script>alert('هیچ کلمه‌ای با امتیاز انتخاب شده در این گروه وجود ندارد. لطفاً امتیاز یا گروه دیگری را انتخاب کنید.'); window.history.back();</script>";
    exit();
}

// انتخاب یک کلمه به صورت تصادفی
$randomWord = $filteredWords[array_rand($filteredWords)];
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازی ادا بازی - نمایش کلمه</title>
    
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
    <style>
        /* استایل برای دکمه در حالت غیرفعال */
        #startButton:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
        /* استایل برای دکمه‌های "صحیح"، "غلط" و "خطا" در حالت غیرفعال */
        .action-button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
    </style>
    <script>
        let timeLeft = <?= $_SESSION['time_limit']; ?>;
        let timerId;

        function startTimer() {
            document.getElementById('startButton').disabled = true;

            // فعال کردن دکمه‌های "صحیح"، "غلط" و "خطا"
            document.getElementById('correctButton').disabled = false;
            document.getElementById('incorrectButton').disabled = false;
            document.getElementById('penaltyButton').disabled = false;

            timerId = setInterval(countdown, 1000);
        }

        function countdown() {
            if (timeLeft == 0) {
                clearTimeout(timerId);
                alert('زمان تمام شد!');
                disableButtons();
            } else {
                document.getElementById('timer').textContent = timeLeft + ' ثانیه';
                timeLeft--;
            }
        }

        function disableButtons() {
            // غیرفعال کردن دکمه‌های "صحیح" و "خطا"
            document.getElementById('correctButton').disabled = true;
            document.getElementById('penaltyButton').disabled = true;
            // دکمه "غلط" فعال می‌ماند
        }

        // اگر صفحه مجدداً بارگذاری شود، دکمه‌های مورد نظر را غیرفعال نگه می‌داریم
        window.onload = function() {
            const startButton = document.getElementById('startButton');
            const correctButton = document.getElementById('correctButton');
            const incorrectButton = document.getElementById('incorrectButton');
            const penaltyButton = document.getElementById('penaltyButton');

            if (startButton.disabled) {
                startButton.style.backgroundColor = 'gray';
                startButton.style.cursor = 'not-allowed';

                // اگر دکمه شروع غیرفعال است، دکمه‌های دیگر را فعال می‌کنیم
                correctButton.disabled = false;
                incorrectButton.disabled = false;
                penaltyButton.disabled = false;
            } else {
                // در غیر این صورت، دکمه‌های دیگر را غیرفعال می‌کنیم
                correctButton.disabled = true;
                incorrectButton.disabled = true;
                penaltyButton.disabled = true;
            }
        }
    </script>
</head>
<body>

<h1>کلمه شما:</h1>
<h2><?= htmlspecialchars($randomWord['کلمه']); ?></h2>

<button id="startButton" onclick="startTimer()">شروع</button>
<p>زمان باقی مانده: <span id="timer"><?= $_SESSION['time_limit']; ?> ثانیه</span></p>

<!-- فرم نتایج -->
<form action="result.php" method="post">
    <input type="hidden" name="points" value="<?= $selectedPoints; ?>">
    <button type="submit" name="result" value="correct" id="correctButton" class="action-button" disabled>صحیح</button>
    <button type="submit" name="result" value="incorrect" id="incorrectButton" class="action-button" disabled>غلط</button>
    <button type="submit" name="result" value="penalty" id="penaltyButton" class="action-button" disabled>خطا</button>
</form>

<!-- دکمه پایان بازی -->
<form action="" method="post">
    <button type="submit" name="end_game" class="end-game-button">پایان بازی و نمایش نتایج</button>
</form>

</body>
</html>
