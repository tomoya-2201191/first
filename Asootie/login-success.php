<?php
session_start();

// ユーザーがログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header("Location: login-input.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-success.css">
    <title>ログイン完了</title>
    <style>
    </style>
</head>
<body>

    <div class=login-success >
    <h1>ログイン完了</h1>
    <a href="top.php" class="button">トップへ</a>
    </div>
</body>
</html>