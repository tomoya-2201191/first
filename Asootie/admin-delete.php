<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db-connect.php';

    $sql = $pdo->prepare('delete from user where user_id=?');
    $sql->execute([$_GET['user_id']]);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者トップ</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/profile.css">
    <!--link rel="stylesheet" href="css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/fade.css">  -->
</head>
<body>
<div class="header-top"></div>

<div class="header">

    <div class="logo">
        <a href="admin-top.php">
            <img src="img/king-logo.png" width="90" height="90">
        </a>
    </div>

</div>

<div class="back-white2">
    <h2 class="h2">削除が完了しました</h2>
    <button class="check_answer" onclick=location.href='admin-top.php'>管理者トップへ</button>
</div>

</body>
</html>