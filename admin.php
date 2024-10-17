<!-- admin.php -->
<?php
session_start();

// بارگذاری کلمات
$wordsData = json_decode(file_get_contents('data/words.json'), true);
$groups = $wordsData['گروه‌ها'];

// افزودن گروه یا کلمه
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_group'])) {
        $groups[] = ['نام' => $_POST['new_group'], 'کلمات' => []];
    } elseif (isset($_POST['group_index']) && isset($_POST['new_word']) && isset($_POST['new_point'])) {
        $groups[$_POST['group_index']]['کلمات'][] = ['کلمه' => $_POST['new_word'], 'امتیاز' => intval($_POST['new_point'])];
    }
    // ذخیره تغییرات
    $wordsData['گروه‌ها'] = $groups;
    file_put_contents('data/words.json', json_encode($wordsData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    header('Location: admin.php');
    exit();
}

// حذف گروه یا کلمه
if (isset($_GET['delete_group'])) {
    array_splice($groups, $_GET['delete_group'], 1);
    $wordsData['گروه‌ها'] = $groups;
    file_put_contents('data/words.json', json_encode($wordsData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    header('Location: admin.php');
    exit();
}
if (isset($_GET['delete_word']) && isset($_GET['group_index'])) {
    array_splice($groups[$_GET['group_index']]['کلمات'], $_GET['delete_word'], 1);
    $wordsData['گروه‌ها'] = $groups;
    file_put_contents('data/words.json', json_encode($wordsData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    header('Location: admin.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت بازی</title>
    
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

<h1>مدیریت گروه‌ها و کلمات</h1>

<!-- افزودن دکمه بازگشت به صفحه اول بازی -->
<p>
    <a href="index.php" class="back-button">بازگشت به صفحه اصلی</a>
</p>

<!-- نمایش گروه‌ها و کلمات به صورت جدول -->
<?php foreach ($groups as $groupIndex => $group): ?>
    <h2>
        <?= $group['نام']; ?>
        <a href="?delete_group=<?= $groupIndex; ?>" class="delete-button">[حذف گروه]</a>
    </h2>
    <table>
        <tr>
            <th>کلمه</th>
            <th>امتیاز</th>
            <th>عملیات</th>
        </tr>
        <?php foreach ($group['کلمات'] as $wordIndex => $word): ?>
            <tr>
                <td><?= $word['کلمه']; ?></td>
                <td><?= $word['امتیاز']; ?></td>
                <td>
                    <a href="?group_index=<?= $groupIndex; ?>&delete_word=<?= $wordIndex; ?>" class="delete-button">حذف</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- فرم افزودن کلمه جدید به گروه -->
    <form action="admin.php" method="post" class="word-form">
        <input type="hidden" name="group_index" value="<?= $groupIndex; ?>">
        <input type="text" name="new_word" placeholder="کلمه جدید" required>
        <input type="number" name="new_point" placeholder="امتیاز" min="2" max="6" step="2" required>
        <button type="submit">افزودن کلمه</button>
    </form>
<?php endforeach; ?>

<!-- فرم افزودن گروه جدید -->
<h2>افزودن گروه جدید</h2>
<form action="admin.php" method="post" class="group-form">
    <input type="text" name="new_group" placeholder="نام گروه" required>
    <button type="submit">افزودن گروه</button>
</form>

</body>
</html>
