<!-- result.php -->
<?php
session_start();

if (!isset($_POST['result']) || !isset($_POST['points'])) {
    header('Location: game.php');
    exit();
}

$result = $_POST['result'];
$points = intval($_POST['points']);

if ($result == 'correct') {
    $_SESSION['scores'][$_SESSION['current_team']] += $points;
} elseif ($result == 'penalty') {
    // اعمال امتیاز منفی یک در صورت انتخاب "خطا"
    $_SESSION['scores'][$_SESSION['current_team']] -= 1;
    if ($_SESSION['scores'][$_SESSION['current_team']] < 0) {
        $_SESSION['scores'][$_SESSION['current_team']] = 0;
    }
}

// تغییر نوبت تیم
$_SESSION['current_team']++;

if ($_SESSION['current_team'] >= $_SESSION['team_count']) {
    $_SESSION['current_team'] = 0;
    $_SESSION['current_round']++;
}

// بازگشت به صفحه بازی یا اتمام بازی
if ($_SESSION['current_round'] > $_SESSION['rounds']) {
    header('Location: final.php');
    exit();
} else {
    header('Location: game.php');
    exit();
}
?>
